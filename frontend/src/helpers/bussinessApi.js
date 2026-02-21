import axios from "axios";

export const BUSINESSAPI = (opts = {}, optsHeader = {}) => {
  /*
  |--------------------------------------------------
  | Custom axios api
  |--------------------------------------------------
  */
  const token = localStorage.getItem("business_token");
  const defaultOptions = {
    ...opts,
    headers: {
      Authorization: token ? `Bearer ${token}` : "",
      ...optsHeader,
    },
    mode: "cors", // no-cors, *cors, same-origin
    cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
    credentials: "same-origin", // include, *same-origin, omit
    redirect: "follow", // manual, *follow, error
    referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
  };

  let baseURL = `${process.env.REACT_APP_API_URL}/`;
  const axiosApi = axios.create({
    baseURL,
    ...defaultOptions,
  });

  axiosApi.interceptors.response.use((response) => {
    return response;
  }, (error) => {
    if (error.response.status === 401) {
      localStorage.removeItem("business_token");
    }
    return Promise.reject(error.response);
  });

  return axiosApi;
};
