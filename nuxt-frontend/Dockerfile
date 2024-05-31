FROM node:20.14.0-alpine

# create destination directory
RUN mkdir -p /usr/src/nuxt-app
WORKDIR /usr/src/nuxt-app

# update and install dependency
RUN apk update && apk upgrade
RUN apk add git

COPY . /usr/src/nuxt-app/
# these don't work properly, though they are the correct sequence of commands.
RUN npm install
RUN npm run generate
RUN npm run build


EXPOSE 3000

ENV NUXT_HOST=0.0.0.0
ENV NUXT_PORT=3000

CMD ["npm", "start"]