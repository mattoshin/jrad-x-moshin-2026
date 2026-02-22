FROM node:18-alpine AS builder

WORKDIR /app
COPY package*.json ./
RUN npm ci --legacy-peer-deps
COPY . .
ENV REACT_APP_API_URL=https://api.galacticsignals.com
ENV REACT_APP_DISCORD_CLIENT_ID=1474956534751432734
ENV REACT_APP_DISCORD_REDIRECT_URL=https://galacticsignals.com/auth/discord/callback
ENV REACT_APP_REDIRECT_URL=https://galacticsignals.com/login
RUN npm run build

FROM nginx:alpine
COPY --from=builder /app/build /usr/share/nginx/html
COPY nginx.conf /etc/nginx/conf.d/default.conf
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
