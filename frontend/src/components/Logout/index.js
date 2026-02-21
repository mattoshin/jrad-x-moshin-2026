import { useAuthContext } from "../../contexts";
import { useNavigate } from "react-router-dom";
import React from "react";

const Logout = () => {
  const { logout } = useAuthContext();
  const navigate = useNavigate();

  React.useEffect(()=>{
    logout();
    navigate("/");
  }, []);

  return (
    <></>
  )
}

export default Logout;