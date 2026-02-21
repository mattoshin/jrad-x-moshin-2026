import { API } from "../helpers";

export const login = (code) => {
  return API({}, { Authorization: "" }).post("api/user/login", {
    code,
    redirect_uri: process.env.REACT_APP_DISCORD_REDIRECT_URL,
  });
}

export const atme = () => {
  return API().get("@me", {});
}