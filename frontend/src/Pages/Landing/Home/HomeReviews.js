import React from "react";
import { Row, Col, Stack } from "react-bootstrap";
import BottomSection from "./Cards/ReviewBottomSection";

const Reviews = () => {
  return (
    <Stack className="review-panel-text">
      <Row className="review-row">
        <Col xs={12}>
          <div className="review-title">Reviews</div>
        </Col>

        <Col xl={4} md={12} className="review-card-wrapper">
          <div className="review-inside-wrapper">
            <div className="small-review-card">
              <div
                style={{ height: "75%", padding: "20px" }}
                className="top-card-wrapper"
              >
                <p className="review-text">
                  The team at Mocean are valuable and consistent characters in
                  Notify's Emerging. Alongside that, the information provided
                  through their service radiates in reliability and accuracy.
                </p>
              </div>
              <div style={{ height: "25%" }} className="bottom-card-wrapper">
                <BottomSection
                  name="banksy#0777"
                  companyName="Head of Administration"
                  imgUrl="https://cdn.discordapp.com/attachments/893629654651510785/976616502071537714/Notify-pfp.png"
                />
              </div>
            </div>
            <div className="small-review-card">
              <div
                style={{ height: "73%", padding: "20px" }}
                className="top-card-wrapper"
              >
                <p className="review-text">
                  Love Ocean and team’s responsiveness and dedication. Great
                  flips and calls, and great options for any customer. I
                  appreciate the team's time and their ability to work with us
                  for any updates or questions!
                </p>
              </div>
              <div style={{ height: "27%" }} className="bottom-card-wrapper">
                <BottomSection
                  name="Chris Mafia#0420"
                  companyName="Owner of House of Carts"
                  imgUrl="https://cdn.discordapp.com/attachments/924019028949868564/982095455506808852/LOGO.png"
                />
              </div>
            </div>
          </div>
        </Col>
        <Col xl={4} md={12} className="review-card-wrapper">
          <div className="review-inside-wrapper">
            <div className="small-review-card">
              <div
                style={{ height: "75%", padding: "20px" }}
                className="top-card-wrapper"
              >
                <p className="review-text">
                  Mocean has been a phenomenal addition to our group. Their
                  services have acted as a foundation for our web3 information.
                  I would highly recommend Mocean's services to other group
                  owners and look forward to seeing their progression onwards.
                </p>
              </div>
              <div style={{ height: "25%" }} className="bottom-card-wrapper">
                <BottomSection
                  name="mckay#0001"
                  companyName="Director of GFNF"
                  imgUrl="https://cdn.discordapp.com/attachments/950080720037113976/976597504785272832/8f7f5402ae8872a13bc953b725e36b50.png"
                />
              </div>
            </div>
            <div className="small-review-card">
              <div
                style={{ height: "73%", padding: "20px" }}
                className="top-card-wrapper"
              >
                <p className="review-text">
                  Mocean is different. If you add everything they offer up, the
                  value for money is exceptional and you'd save a lot of money
                  than going to other providers individually. Finally, they are
                  continually improving their service and they have your best
                  interest at heart. Would recommend!
                </p>
              </div>
              <div style={{ height: "27%" }} className="bottom-card-wrapper">
                <BottomSection
                  name="BEN.#5724"
                  companyName="Owner of Juiced"
                  imgUrl="https://cdn.discordapp.com/attachments/698530042082361355/752679721652846643/Juiced_SNKRS_White_BG.png"
                />
              </div>
            </div>
          </div>
        </Col>

        <Col xl={4} md={12} className="review-card-wrapper">
          <div className="review-inside-wrapper">
            <div className="small-review-card">
              <div
                style={{ height: "75%", padding: "20px" }}
                className="top-card-wrapper"
              >
                <p className="review-text">
                  This service is amazing! I love all of the info they provide,
                  and the amount of info given is AMAZING. Definitely worth it,
                  10/10. The in-depth analysis is solid and very well written,
                  definitely a time saver.
                </p>
              </div>
              <div style={{ height: "25%" }} className="bottom-card-wrapper">
                <BottomSection
                  name="KosherPlug#0001"
                  companyName="Owner of Kosher Crew"
                  imgUrl="https://cdn.discordapp.com/attachments/941002274300395610/981778900248047616/B7E11031-EF26-470F-90FF-C1A107219593.jpg"
                />
              </div>
            </div>
            <div className="small-review-card">
              <div
                style={{ height: "73%", padding: "20px" }}
                className="top-card-wrapper"
              >
                <p className="review-text">
                  I've been working with Ocean since before NFTs became the new
                  craze and I've always been impressed by him, especially with
                  what he's created here at Mocean. The calls provided are peak,
                  the style and execution are amazing, and the team is
                  constantly expanding.
                </p>
              </div>
              <div style={{ height: "27%" }} className="bottom-card-wrapper">
                <BottomSection
                  name="Hyped#0001"
                  companyName="Owner of Platinum Tools"
                  imgUrl="https://cdn.discordapp.com/attachments/748707924897038427/976899949402939453/A1CE6F05-1F99-4F7A-BCA7-BE3BA9A14582.jpg"
                />
              </div>
            </div>
          </div>
        </Col>
      </Row>
    </Stack>
  );
};

export default Reviews;
