import { BUSINESSAPI } from "../helpers";

export const invoices = () => {
  return BUSINESSAPI().get("api/business/@me/invoices", {});
}

export const invoice = (id) => {
  return BUSINESSAPI().get(`api/business/@me/invoices/${id}`, {});
}
