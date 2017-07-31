FROM php:7.0-fpm-alpine
ADD index.php /var/www/html
EXPOSE 8000
HEALTHCHECK --interval=60s --timeout=30s CMD curl --fail http://localhost:8000/ || exit 1
CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html"]