#!/bin/bash

# 判断 docker-compose 是否执行
function verify_docker_exists() {
    echo "||# =>=>=>=>=>=>=>=>=>=>=>=>=>=>=> [判定容器是否存在] =>=>=>=>=>=>=>=>=>=>=>=>=>=>=> #||"

    # shellcheck disable=SC2154
    container[0]="${DockerAppID}-web-service"
    container[1]="${DockerAppID}-php-service"
    container[2]="${DockerAppID}-mysql-service"
    container[3]="${DockerAppID}-redis-service"

    index=0

    for (( i = 0; i < ${#container[*]}; i++ )); do
        echo "||# =>=>=>=>=>=>=>=>=>=>=>=>=>=>=> [第 ${i} 项 - ${container[i]}] =>=>=>=>=>=>=>=>=>=>=>=>=>=>=> #||"

        # shellcheck disable=SC2046
        if [ $(docker ps -a -f name="${container[i]}") ]; then
            echo "||# =>=>=>=>=>=>=>=>=>=>=>=>=>=>=> [存在] =>=>=>=>=>=>=>=>=>=>=>=>=>=>=> #||"
        else
            echo "||# =>=>=>=>=>=>=>=>=>=>=>=>=>=>=> [不存在] =>=>=>=>=>=>=>=>=>=>=>=>=>=>=> #||"
            index=$((index+1))
        fi

    done

    if [ $index == 4 ]; then
        echo "||# =>=>=>=>=>=>=>=>=>=>=>=>=>=>=> [容器均不存在 - 符合初始化条件] =>=>=>=>=>=>=>=>=>=>=>=>=>=>=> #||"
        echo "||# =>=>=>=>=>=>=>=>=>=>=>=>=>=>=> [执行容器编排] =>=>=>=>=>=>=>=>=>=>=>=>=>=>=> #||"
        docker-compose up -d
        echo "||# =>=>=>=>=>=>=>=>=>=>=>=>=>=>=> [进入 (PHP) 容器执行 (composer)] =>=>=>=>=>=>=>=>=>=>=>=>=>=>=> #||"
        # docker exec -it -w /var/www/html "${container[1]}" pwd

        # 根据 vendor 目录判断是需要初始化还是更新包
        if [ -d "vendor" ];then
            docker exec -w /var/www/html "${container[1]}" composer install
        else
            docker exec -w /var/www/html "${container[1]}" composer update
        fi
    fi
}

echo "||# =>=>=>=>=>=>=>=>=>=>=>=>=>=>=> [开始构建] =>=>=>=>=>=>=>=>=>=>=>=>=>=>=> #||"

if [ ! -f ".env" ]; then
    echo "||# =>=>=>=>=>=>=>=>=>=>=>=>=>=>=> [(.env)不存在 - 拷贝(.env.example) 到 (.env)] =>=>=>=>=>=>=>=>=>=>=>=>=>=>=> #||"
    cp .env.example .env
fi

verify_docker_exists
