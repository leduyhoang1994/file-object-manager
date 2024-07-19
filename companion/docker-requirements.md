# Requirements for writing docker

## Flow
![image](https://github.com/user-attachments/assets/0ae70649-99b7-42f4-99a6-5fb600ad7745)


## Folder path
1. docker/nginx.conf
2. ./Dockerfile
3. ./docker-compose.yml
4. ./ecosystem.config.js (using for pm2)

## Requirements
1. Writing ecosystem file for pm2 to run companion in both cluster and standalone mode. [Documentation](https://pm2.keymetrics.io/docs/usage/application-declaration/)
2. Writing a Dockerfile for installation and running companion
3. Writing a docker-compose.yml with 2 services
   - companion
   - nginx
4. Writing nginx configuration file for loadbalancing companion [Documentation](https://docs.nginx.com/nginx/admin-guide/load-balancer/http-load-balancer/)
