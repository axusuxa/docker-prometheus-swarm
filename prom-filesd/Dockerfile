FROM php:7.0-fpm
ADD index.php /var/www/html
EXPOSE 8000
#HEALTHCHECK --interval=10s --timeout=10s --start-period=15s CMD curl --fail http://localhost:8000/ || exit 1
CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html"]