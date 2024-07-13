<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ValidationException;
use Doctrine\ORM\EntityNotFoundException;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Validator\ConstraintViolation;

use function array_key_exists;
use function getenv;
use function getmypid;

class ExceptionListener implements EventSubscriberInterface
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $errors = [];
        $code = $exception->getCode();

        if (200 > $code) {
            $code = 500;
        }
        $exceptionMessage = 'Внутренняя ошибка';

        if ($exception instanceof ValidationException) {
            $exceptionMessage = 'Ошибка данных формы';

            /** @var ConstraintViolation $violation */
            foreach ($exception->getViolations() as $violation) {
                if (!array_key_exists($violation->getPropertyPath(), $errors)) {
                    $errors[$violation->getPropertyPath()] = [];
                }

                $errors[$violation->getPropertyPath()][] = $violation->getMessage();
            }

            $code = Response::HTTP_UNPROCESSABLE_ENTITY;
        } elseif ($exception instanceof InvalidArgumentException) {
            $exceptionMessage = $exception->getMessage();
            $code = Response::HTTP_UNPROCESSABLE_ENTITY;
        } elseif ($exception instanceof EntityNotFoundException) {
            $exceptionMessage = $exception->getMessage();
            $code = Response::HTTP_NOT_FOUND;
        } else {
            $this->logger->error($exception->getMessage(), $exception->getTrace());
        }

        $exceptionMessage = $exception->getMessage(); // TODO remove
        $event->setResponse(
            new JsonResponse(
                [
                    'errors' => $errors,
                    'code' => $code,
                    'message' => $exceptionMessage,
                    'processId' => getmypid(),
                    'errorTittle' => getenv('APP_DEBUG') ? $exception->getMessage() : '',
                    'stackTrace' => getenv('APP_DEBUG') ? $exception->getTrace() : [],
                ],
                $code
            )
        );
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        // $response = $event->getResponse();

        //        // Set multiple headers simultaneously
        //        $response->headers->add([
        //            'Api-Version' => 1,
        //        ]);
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }
}
