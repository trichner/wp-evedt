# Evedt
This is a WordPress Plugin/Widget that integrates the Eve Online Donation Tracker.


# Setup

This requires the following tracker as a backend:
https://github.com/trichner/evedt

# Example NGINX Config
```
upstream php {
        server unix:/tmp/php-cgi.socket;
        server 127.0.0.1:9000;
}

server {
        listen 80 default_server;

        server_name example.org localhost;
        root /var/www/wordpress;

        index index.php;

        location = /favicon.ico {
                log_not_found off;
                access_log off;
        }

        location = /robots.txt {
                allow all;
                log_not_found off;
                access_log off;
        }

        location / {
                # This is cool because no php is touched for static content.
                # include the "?$args" part so non-default permalinks doesn't break when using query string
                try_files $uri $uri/ /index.php?$args;
        }

        location ~ \.php$ {
                fastcgi_split_path_info ^(.+\.php)(/.+)$;
                # NOTE: You should have "cgi.fix_pathinfo = 0;" in php.ini

                # With php5-cgi alone:
                # fastcgi_pass 127.0.0.1:9000;
                # With php5-fpm:
                fastcgi_pass unix:/var/run/php5-fpm.sock;
                fastcgi_index index.php;
                include fastcgi_params;
        }

        location ~* \.(js|css|png|jpg|jpeg|gif|ico)$ {
                expires max;
                log_not_found off;
        }

         location /api/ {
                proxy_pass http://localhost:8080/api/;

                proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
                proxy_set_header Host $host;
                proxy_set_header X-Real-IP $remote_addr;
        }

}
```
