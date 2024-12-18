FROM southwan/phpswoole8.2:beta0.1

WORKDIR "${DOCKER_RUN_DIRECTORY}"

RUN docker-php-source extract

# 安装必要扩展库
RUN docker-php-ext-install pcntl
