# select node image
FROM node:20-alpine

# create destination directory
WORKDIR /app

# copies package.json and package-lock.json to the container
COPY package*.json ./
RUN npm install
# copies nuxt files to container
COPY . .
# builds the app
RUN npm run build

# start app
CMD ["npm", "start"]
