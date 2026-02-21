import { useEffect } from "react";
import { Navigate, Outlet } from "react-router-dom";
import { useAuthContext } from "../../contexts";

const BusinessAuthentication = () => {
  const { token } = useAuthContext();
  let isAuthorizedInternalyForBusiness = localStorage.getItem("business_token");
  if (!isAuthorizedInternalyForBusiness) {
    let localToken = localStorage.getItem("token");
    if (!localToken) {
      return ( 
        <Navigate to="/login" /> 
      );
    }
  }

  return token && isAuthorizedInternalyForBusiness ? (
    <Outlet />
  ) : !isAuthorizedInternalyForBusiness ? (
    <Navigate to="/switch-business" />
  ) : (
    <Navigate to="/login" />
  );
};

export default BusinessAuthentication;
