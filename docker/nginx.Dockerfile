FROM nginx:latest

RUN mkdir -p /var/run/nginx

COPY docker/config/default.nginx        /etc/nginx/nginx.conf.template
COPY docker/docker-nginx-entrypoint     /usr/local/bin/

ENTRYPOINT ["docker-nginx-entrypoint"]
CMD ["nginx", "-g", "daemon off;"]
