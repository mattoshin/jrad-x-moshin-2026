import React, { useEffect} from "react";
import { Row, Col, Button, Stack } from "react-bootstrap";
import { useNavigate, Navigate } from "react-router-dom";
import animateScrollTo from "animated-scroll-to";
import logo from "../../assets/logo.png";
import './Login.css';
import { useAuthContext } from "../../contexts";

const Login = () => {
  const { isLogined, token} = useAuthContext();
  if (isLogined || token) {
    return (
      <Navigate to="/switch-business" />
    );
  } else {
    return (
      <>
        <div className="content-container">
          <Row>
            <Col xl={6} lg={12} xs={12} className="login-left-side">
              <Stack className="login-text-stack">
                <div className="login-text">Welcome Back</div>
                <div className="hero-title">Login to Your Dashboard</div>
                <Col lg={5} className="d-flex login-btn-wrapper">            
                  <a
                    className="login-btn"
                    href={process.env.REACT_APP_REDIRECT_URL}
                    // target="_blank"
                    // rel="noreferrer"
                  >
                    Sign in with Discord
                  </a>
                </Col>
              </Stack>
            </Col>
            <Col xl={6} lg={6} xs={12}>
              <div className="login-dashboard-image">
                <div className="dashboard-header">
                  <div className="dashboard-row">
                    <div className="dashboard-circle" />
                    <div className="dashboard-circle" />
                    <div className="dashboard-circle" />
                  </div>
                  <div className="dashboard-img-container">
                    <img src={logo} width={350} height={350} />
                  </div>
                </div>
              </div>
            </Col>
          </Row>
        </div>
      </>
    );
  }
};

export default Login;
