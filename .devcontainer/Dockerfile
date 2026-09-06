# Quick dev environment for this Jekyll site, built on top of the shared
# kasterma-dev-pi base (gets Claude Code + pi for free) with Ruby layered on.
FROM docker.io/kasterma/kasterma-dev-pi:2026.08.18

USER root
RUN apt-get update && apt-get install -y ruby-full && rm -rf /var/lib/apt/lists/*
USER ubuntu

ENV GEM_HOME="/home/ubuntu/.gem" \
    PATH="/home/ubuntu/.gem/bin:${PATH}"

RUN gem install bundler

WORKDIR /workspace
