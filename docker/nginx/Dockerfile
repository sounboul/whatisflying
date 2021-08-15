FROM nginx:1.21

COPY config/nginx.conf /etc/nginx/nginx.conf
COPY config/dev.whatisflying.com.conf /etc/nginx/conf.d/dev.whatisflying.com.conf

RUN apt-get update && \
    apt-get install -y openssl && \
    mkdir -p /etc/nginx/ssl && \
    #openssl dhparam -out /etc/nginx/ssl/dhparam.pem 4096 && \
    openssl req -x509 -nodes -days 3650 -newkey rsa:4096 \
        -keyout /etc/nginx/ssl/dev.whatisflying.com.key \
        -out /etc/nginx/ssl/dev.whatisflying.com.cert \
        -subj "/CN=dev.whatisflying.com" && \
    mkdir -p /usr/share/nginx/html/config/jwt && \
    openssl genpkey -out /usr/share/nginx/html/config/jwt/private.pem \
        -pass pass:3332c73f0b28f8df5bac7d7c17c91edc -aes256 \
        -algorithm rsa -pkeyopt rsa_keygen_bits:4096 && \
    openssl pkey -in /usr/share/nginx/html/config/jwt/private.pem \
        -passin pass:3332c73f0b28f8df5bac7d7c17c91edc \
        -out /usr/share/nginx/html/config/jwt/public.pem -pubout
