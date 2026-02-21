import React from "react";
import { Col, Button, Stack } from "react-bootstrap";
import logo from "../../../assets/logo.png";
import { useNavigate } from "react-router-dom";
import animateScrollTo from "animated-scroll-to";

const HomeBanner = () => {
  const navigate = useNavigate();
  return (
    <>
      <Col xl={6} lg={12} xs={12} className="welc-left-side">
        <Stack className="welc-text-stack">
          <div className="welcome-text">WELCOME TO MOCEAN</div>
          <div className="hero-title">Premier B2B</div>
          <div className="hero-title">Information Services</div>
          <div className="hero-description w-75">
            Mocean provides the earliest alpha, most thorough analysis, and best
            release guides for your community.
          </div>
          <Col lg={5} className="d-flex welc-btn-wrapper">
            <Button variant="none" className="welc-btn" onClick={()=>{
              navigate("switch-business");
            }}>
              Dashboard
            </Button>
            <a
              style={{
                cursor: "pointer",
                border: "none",
                textDecoration: "none",
                background: "none",
                boxShadow: "none",
              }}
              onClick={() => {
                let el = document.getElementById("about-us");
                animateScrollTo(el, { speed: 1400 });
              }}
              variant="none"
              className="ms-2 welc-btn text-center d-flex align-items-center justify-content-center"
            >
              Learn More
            </a>
          </Col>
        </Stack>
      </Col>
      <Col xl={6} lg={6} xs={12}>
        <div className="dashboard-image">
          <div className="dashboard-header">
            <div className="dashboard-row">
              <div className="dashboard-circle" />
              <div className="dashboard-circle" />
              <div className="dashboard-circle" />
            </div>
            {/* Shark Image */}
            <div className="dashboard-img-container">
              <img src={logo} width={350} height={350} />
            </div>

            {/* Dashboard Image */}
            {/* <div className="dashboard-img-container">
                <img
                  src={preview}
                  width={"100%"}
                  height={"100% !important"}
                  style={{ zIndex: "-1", bottom: "0px" }}
                />
              </div> */}
          </div>
        </div>
      </Col>
    </>
  );
};

export default HomeBanner;
