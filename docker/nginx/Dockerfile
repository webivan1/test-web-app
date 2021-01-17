FROM nginx:1.19.3-alpine

RUN apk add --no-cache curl

COPY ./default.conf /etc/nginx/conf.d/default.conf

WORKDIR /app
