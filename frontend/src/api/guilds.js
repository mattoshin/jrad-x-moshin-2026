import { API } from "../helpers";

export const guilds = () => {
  return API().get("guilds", {});
}