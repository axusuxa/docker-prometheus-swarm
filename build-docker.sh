#!/bin/sh
docker build -t gitlab.sanookonline.co.th:9443/itinfra/docker-prometheus-swarm:latest .
docker push gitlab.sanookonline.co.th:9443/itinfra/docker-prometheus-swarm:latest