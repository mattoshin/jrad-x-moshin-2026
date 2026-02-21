import React from "react";
import { Row } from "react-bootstrap";
import Footer from "../../../components/Footer/index";
import HomeBanner from "./HomeBanner";
import HomeInfo from "./HomeInfo";
import ContactUs from "./HomeContactUs";
import Reviews from "./HomeReviews";
import HomeConnect from "./HomeConnect";

export const Home = () => {
  return (
    <div className="content-container" id="starting-div">
      <Row style={{ margin: 0 }}>
        <HomeBanner />
      </Row>
      <HomeInfo />
      {/* <Row className="stats-panel">
        <Col className="stats-panel-card">
          <Stack>
            <Col className="stats-title">400+</Col>
            <Col className="stats-desc">Communities</Col>
          </Stack>
        </Col>
        <Col className="stats-panel-card">
          <Stack>
            <Col className="stats-title">200K</Col>
            <Col className="stats-desc">Messages Sent</Col>
          </Stack>
        </Col>
        <Col className="stats-panel-card">
          <Stack>
            <Col className="stats-title">$15M</Col>
            <Col className="stats-desc">Profits Earned</Col>
          </Stack>
        </Col>
      </Row> */}
      <ContactUs />
      <Reviews />
      <HomeConnect />
      <Footer />
    </div>
  );
};
