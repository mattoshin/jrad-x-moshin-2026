import { API } from "../helpers";

export const businessCreate = (server) => {
  return API().post("api/businesses/create", {
    server,
  });
}

export const checkout = (id, token) => {
  return API().get(`api/business/@me/products/${id}/checkout`, {
    params: {
      token: token
    }
  });
}

export const portalApi = (token) => {
  return API().get(`api/business/@me/create_portal`, {
    params: {
      token: token
    }
  });
}
