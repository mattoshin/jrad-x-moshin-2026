import React from "react";
import { Row, Col, Stack } from "react-bootstrap";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";

import { faTwitter, faDiscord } from "@fortawesome/free-brands-svg-icons";

const HomeConnect = () => {
  return (
    <Row style={{ margin: 0 }}>
      <div className="social-title">Connect with us</div>
      <div className="d-flex justify-content-center">
        <div className="social-card-wrapper">
          <a href="https://discord.gg/F7syGdJMZq">
            <Stack className="social-card">
              <Col className="social-icon">
                <FontAwesomeIcon icon={faDiscord} className="mr-2" />
              </Col>
            </Stack>
          </a>
        </div>
        <div className="social-card-wrapper ms-3">
          <a href="https://twitter.com/moceanofficial">
            <Stack className="social-card">
              <Col className="social-icon">
                <FontAwesomeIcon icon={faTwitter} className="mr-2" />
              </Col>
            </Stack>
          </a>
        </div>
      </div>
    </Row>
  );
};

export default HomeConnect;
