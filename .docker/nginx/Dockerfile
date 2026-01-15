FROM nginx:1.21-alpine

COPY nginx.conf /etc/nginx/nginx.conf
COPY templates /etc/nginx/templates/

RUN echo "upstream php-upstream { server app:9000; }" > /etc/nginx/conf.d/upstream.conf

# Create public directory
RUN mkdir -p /var/www/symfony/public

EXPOSE 80
