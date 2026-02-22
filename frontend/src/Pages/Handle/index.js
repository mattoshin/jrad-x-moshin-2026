import axios from "axios";
import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { useAuthContext } from "../../contexts";
import {
  login as loginApi,
  atme as atmeApi
} from "../../api";

const Handle = () => {
  const [errorMsg, setErrorMsg] = useState("");
  const { login, isLogined } = useAuthContext();
  const navigate = useNavigate();

  const initiateAuth = async (code) => {
    if (!code) {
      setErrorMsg("No authorization code received from Discord.");
      return;
    }
    try {
      // Token exchange now happens server-side to protect client_secret
      const userResponse = await loginApi(code.toString());
      if (!userResponse.data.token) {
        setErrorMsg(userResponse.data.message || "Error occurred while authenticating user");
        return;
      }

      localStorage.setItem("token", userResponse.data.token);

      try {
        const atMeResponse = await atmeApi();
        if (!atMeResponse.data.user) {
          setErrorMsg("Error occurred while initializing user");
          return;
        }
        localStorage.setItem("username", atMeResponse.data.user.username);
        localStorage.setItem("email", atMeResponse.data.user.email);

        const avatarURL = `https://cdn.discordapp.com/avatars/${atMeResponse.data.user.discordId}/${atMeResponse.data.user.avatar}.webp?size=100`;
        try {
          await axios.get(avatarURL);
          localStorage.setItem("avatar", avatarURL);
        } catch {
          localStorage.setItem("avatar", "https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80");
        }

        login(userResponse.data.token, atMeResponse.data.user.email, atMeResponse.data.user.username);
        navigate("/dashboard");
      } catch (err) {
        setErrorMsg("Error occurred while loading your profile.");
      }
    } catch (err) {
      setErrorMsg("Error occurred while connecting to the server.");
    }
  };

  useEffect(() => {
    if (isLogined) {
      navigate("/dashboard");
      return;
    }
    const params = new URLSearchParams(window.location.search);
    const code = params.get("code");
    initiateAuth(code);
  }, []);

  if (errorMsg) {
    return (
      <div style={{
        position: "fixed",
        left: 0, top: 0,
        width: "100%", height: "100%",
        backgroundColor: "#30343a",
        display: "flex",
        flexDirection: "column",
        alignItems: "center",
        justifyContent: "center",
        color: "#fff",
        fontSize: "18px",
        gap: "16px",
      }}>
        <p>{errorMsg}</p>
        <button
          onClick={() => navigate("/login")}
          style={{
            padding: "10px 24px",
            background: "#5865f2",
            color: "#fff",
            border: "none",
            borderRadius: "6px",
            cursor: "pointer",
            fontSize: "16px",
          }}
        >
          Try Again
        </button>
      </div>
    );
  }

  return (
    <div style={{
      position: "fixed",
      left: 0, top: 0,
      width: "100%", height: "100%",
      backgroundColor: "#30343a",
      display: "flex",
      alignItems: "center",
      justifyContent: "center",
    }}>
      <p style={{ color: "#fff", fontSize: "18px" }}>Logging you in...</p>
    </div>
  );
};

export default Handle;
