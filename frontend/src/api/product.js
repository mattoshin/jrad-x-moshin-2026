import { BUSINESSAPI } from "../helpers";

export const products = () => {
  return BUSINESSAPI().get("api/business/@me/products", {});
}

export const activeProducts = () => {
  return BUSINESSAPI().get("api/business/@me/products/active", {});
}

export const businessAtme = () => {
  return BUSINESSAPI().get("api/business/@me", {});
}

export const updateBusinessAtme = (data) => {
  return BUSINESSAPI().post("api/business/@me/settings", data);
}

export const announcements = () => {
  return BUSINESSAPI().get(`api/business/@me/announcements`, {});
}

export const getProductAnnouncement = (id) => {
  return BUSINESSAPI().get(`api/business/@me/products/${id}/announcements`, {});
}

export const getPlan = (id) => {
  return BUSINESSAPI().get(`api/business/@me/plans/${id}`, {});
}

export const updatePlan = (id, data) => {
  return BUSINESSAPI().put(`api/business/@me/plans/${id}`, data);
}

export const getMonitorsbyId = (id) => {
  return BUSINESSAPI().get(`api/business/@me/monitors/${id}`, {});
}

export const getMonitorWebhook = (id) => {
  return BUSINESSAPI().get(`api/business/@me/monitors/${id}/webhooks`, {});
}

export const updateWebhook = (id, data) => {
  return BUSINESSAPI().post(`api/business/@me/monitors/${id}/webhooks`, data);
}

export const cancelProduct = (id, data) => {
  return BUSINESSAPI().post(`api/business/@me/products/${id}/cancel`, data);
}
