<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use App\Exception\ValidationException;
use App\Request\RequestInterface;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Throwable;

use const JSON_THROW_ON_ERROR;

use function in_array;
use function is_array;

class RequestDataResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private DenormalizerInterface $denormalizer
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_subclass_of((string) $argument->getType(), RequestInterface::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        $routeParams = iterator_to_array($request->attributes->getIterator())['_route_params'] ?? [];
        $queryParams = iterator_to_array($request->query->getIterator());
        $requestParams = iterator_to_array($request->request->getIterator());
        $requestData = array_merge(
            $routeParams,
            $queryParams,
            $requestParams,
            $this->decodeRequestBodyParams($request)
        );

        /** @var RequestInterface $data */
        $data = $this->denormalizer->denormalize(
            $requestData,
            (string) $argument->getType(),
            null,
            [
                ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true, ]
        );

        yield $data;
    }

    protected function decodeRequestBodyParams(Request $request): array
    {
        $bodyParams = [];
        $contentType = explode(';', $request->headers->get('Content-Type', ''));

        if (in_array('application/json', $contentType, true) && '' !== $request->getContent()) {
            try {
                $requestContent = $request->getContent();
                $body = json_decode($requestContent, true, 512, JSON_THROW_ON_ERROR);

                if (is_array($body)) {
                    $bodyParams = $body;
                }
            } catch (Throwable $ex) {
                throw new ValidationException('Body is not valid JSON: ' . $ex->getMessage(), 500);
            }
        }

        return $bodyParams;
    }
}
