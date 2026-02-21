import React from "react";
import { Row, Col, Stack } from "react-bootstrap";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
  faNewspaper,
  faMagnifyingGlassChart,
  faBook,
  faStopwatch,
  faBookOpenReader,
  faSackDollar,
} from "@fortawesome/free-solid-svg-icons";

const HomeInfo = () => {
  return (
    <Stack className="desc-panel-text">
      <div id="about-us" className="about-title">
        Unparalleled Information Curation and Aggregation
      </div>
      <div className="about-description">
        The Mocean team is composed of over 50 web3, crypto, and NFT experts.
        All of our analysts work full-time in the web3 space to give your
        community comprehensive release guides, investment analysis, news, macro
        trends, educational content, and much more. No more having to spend
        hours trying to compile information from different sources: our analysts
        seek out and curate only the most important material to save you more
        time and make your clients more profit.
      </div>
      <Row className="about-row">
        <Col className="about-column" xl={4}>
          <div className="about-icon">
            <FontAwesomeIcon icon={faNewspaper} className="mr-2" />
          </div>
          <div className="about-mini-title">News & Macro Trends</div>
          <div className="about-mini-desc">
            Keep up to date with the news you need to know.
          </div>
        </Col>
        <Col className="about-column" xl={4}>
          <div className="about-icon">
            <FontAwesomeIcon icon={faMagnifyingGlassChart} className="mr-2" />
          </div>
          <div className="about-mini-title">In-Depth Release Guides</div>
          <div className="about-mini-desc">Never miss a profitable drop.</div>
        </Col>
        <Col className="about-column" xl={4}>
          <div className="about-icon">
            <FontAwesomeIcon icon={faBook} className="mr-2" />
          </div>
          <div className="about-mini-title">Project Analysis</div>
          <div className="about-mini-desc">
            Make informed investment decisions.
          </div>
        </Col>
      </Row>
      <Row className="about-row">
        <Col className="about-column" xl={4}>
          <div className="about-icon">
            <FontAwesomeIcon icon={faStopwatch} className="mr-2" />
          </div>
          <div className="about-mini-title">Whitelist Opportunities</div>
          <div className="about-mini-desc">
            Find profitable projects before anyone else.
          </div>
        </Col>
        <Col className="about-column" xl={4}>
          <div className="about-icon">
            <FontAwesomeIcon icon={faBookOpenReader} className="mr-2" />
          </div>
          <div className="about-mini-title">Educational Content</div>
          <div className="about-mini-desc">
            Learn from experts in the space.
          </div>
        </Col>
        <Col className="about-column" xl={4}>
          <div className="about-icon">
            <FontAwesomeIcon icon={faSackDollar} className="mr-2" />
          </div>
          <div className="about-mini-title">And Much More…</div>
          <div className="about-mini-desc">
            See our clients’ success for yourself.
          </div>
        </Col>
      </Row>
    </Stack>
  );
};

export default HomeInfo;
