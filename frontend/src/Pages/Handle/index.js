import axios from "axios";
import { useEffect, useState } from "react";
import { Navigate } from "react-router-dom";
import { useAuthContext } from "../../contexts";
import { 
  login as loginApi,
  atme as atmeApi
} from "../../api";

const Handle = () => {
  const [error, setError] = useState("");
  const { login, isLogined } = useAuthContext();

  const initiateAuth = async (code) => {
    try {
      // Token exchange now happens server-side to protect client_secret
      const userResponse = await loginApi(code.toString());
      if(!userResponse.data.token) {
        setError(userResponse.data.error || "Error occur while authenticating user");
      }
      
      localStorage.setItem("token", userResponse.data.token);

      try {
        const atMeResponse = await atmeApi();
        if(!atMeResponse.data.user) {
          setError("Error occured while initializing user");
        }
        localStorage.setItem("username", atMeResponse.data.user.username);
        localStorage.setItem("email", atMeResponse.data.user.email);  
        
        const avatarURL = `https://cdn.discordapp.com/avatars/${atMeResponse.data.user.discordId}/${atMeResponse.data.user.avatar}.webp?size=100`;
        try {
          const res = await axios.get(avatarURL);
          localStorage.setItem("avatar", avatarURL);
        } catch(error) {
          localStorage.setItem("avatar", "https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80");
        }
        
        login(userResponse.data.token, atMeResponse.data.user.email, atMeResponse.data.user.username);
      } catch (error) {
        setError(error);
      }
    } catch (error) {
      setError(`error while initiating auth:" ${error}`);
    }
  };

  useEffect(() => {
    const search = window.location.search;
    const params = new URLSearchParams(search);
    const code = params.get("code");
    initiateAuth(code);
  }, []);
  return (
    <div>
      {isLogined ? <Navigate to="/switch-business" /> : 
      <div style={{ 
        
        position: "fixed",
        left: "0px",
        top: "0px",
        width: "100%",
        height: "100%",
        zIndex: 999,
        backgroundImage: "url(https://c.tenor.com/s-u8sx-iaiQAAAAM/loading-dots.gif)",
        backgroundRepeat: 'no-repeat',
        backgroundPosition: 'center',
        backgroundColor: '#30343a'
      }}></div>}
      
    </div>
  );
};

export default Handle;
