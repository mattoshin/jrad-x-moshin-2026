import { useEffect } from "react";
import { Navigate, Outlet } from "react-router-dom";
import { useAuthContext } from "../../contexts";

const RequireAuth = () => {
  const { isLogined, token} = useAuthContext();
  if (!isLogined || !token) {
    return ( 
      <Navigate to="/login" /> 
    );
  } else {
    return token && <Outlet />;
  }
};

export default RequireAuth;
