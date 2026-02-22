import React from "react";
import { Navigate } from "react-router-dom";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faDiscord } from "@fortawesome/free-brands-svg-icons";
import "./Login.css";
import { useAuthContext } from "../../contexts";

const GoogleIcon = () => (
  <svg width="20" height="20" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
    <path fill="none" d="M0 0h48v48H0z"/>
  </svg>
);

const RocketIcon = () => (
  <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="white" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" xmlns="http://www.w3.org/2000/svg">
    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/>
    <path d="M12 15l-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/>
    <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/>
    <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/>
  </svg>
);

const Login = () => {
  const { isLogined, token } = useAuthContext();

  const handleDiscordLogin = () => {
    const redirectUri = encodeURIComponent(process.env.REACT_APP_DISCORD_REDIRECT_URL);
    const clientId = process.env.REACT_APP_DISCORD_CLIENT_ID;
    window.location.href = `https://discord.com/oauth2/authorize?client_id=${clientId}&redirect_uri=${redirectUri}&response_type=code&scope=identify%20email%20guilds`;
  };

  const handleGoogleLogin = () => {
    // TODO: implement Google OAuth
  };

  if (isLogined || token) {
    return <Navigate to="/dashboard" />;
  }

  return (
    <div className="galactic-login-page">
      <div className="galactic-login-card">
        <div className="galactic-rocket-icon">
          <RocketIcon />
        </div>
        <h1 className="galactic-title">Galactic</h1>
        <p className="galactic-subtitle">Sign in to manage your data monitors</p>

        <div className="galactic-btn-group">
          <button className="galactic-btn" onClick={handleGoogleLogin}>
            <GoogleIcon />
            <span>Continue with Google</span>
          </button>
          <button className="galactic-btn" onClick={handleDiscordLogin}>
            <FontAwesomeIcon icon={faDiscord} className="galactic-discord-icon" />
            <span>Continue with Discord</span>
          </button>
        </div>
      </div>
    </div>
  );
};

export default Login;
