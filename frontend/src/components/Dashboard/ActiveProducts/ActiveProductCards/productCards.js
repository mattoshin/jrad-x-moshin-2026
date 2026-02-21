// import { faCheckCircle } from "@fortawesome/free-regular-svg-icons";
import {
  faCheckCircle,
  faComment,
  faEllipsisVertical,
  faPlus,
  faTrashCan,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import "../styles.css";
import { useNavigate } from "react-router-dom";

const ProductCards = ({ product }) => {
  const nav = useNavigate();
  return (
    <div className="col-12 col-md-12 col-lg-4 p-3">
      <div className="product-card" onClick={() => nav(`/manage/`)}>
        {/* <div
        className="p-3"
        style={{ borderRadius: "4px", backgroundColor: "#1E222B " }}
      >
        <div className="d-flex justify-content-between align-items-center mb-4">
          <h6 className="m-0 text-white">{product.date}</h6>
          <FontAwesomeIcon color="white" icon={faEllipsisVertical} size="lg" />
        </div>

        <div className="d-flex justify-content-center">
          <div>
            <img
              style={{ display: "flex", alignSelf: "center" }}
              className="rounded-circle"
              height="80"
              width="80"
              src="https://images.unsplash.com/photo-1518893063132-36e46dbe2428?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=735&q=80"
            />
          </div>
        </div>
        <h4 className="mt-3 text-center text-white">{product.title}</h4>
        <h6
          className="mt-3 text-center text-white"
          style={{ fontWeight: "lighter" }}
        >
          {product.subtitle}
        </h6>
        <h6 className="mt-3 text-center text-white">{product.price}</h6>
        <div className="d-flex justify-content-center">
          <button
            className="mt-3 text-center"
            style={{
              width: "80px",
              backgroundColor: "#2F3541",
              color: product.status === "Active" ? "#50E34D" : "red",
              border: "none",
              borderRadius: "17px",
            }}
          >
            {product.status}
          </button>
        </div>
        <div className="d-flex justify-content-center mt-4 mb-3">
          <div className="progress active-sub-card-progress d-flex align-self-center ms-2">
            <div
              className="progress-bar active-sub-card-progress-right"
              role="progressbar"
              aria-valuenow="25"
              aria-valuemin="0"
              aria-valuemax="100"
            ></div>
          </div>
          <div className="d-flex">
            <h6 className="text-white d-flex ms-3 m-0">{product.days}</h6>
            <h6
              className="d-flex m-0 align-self-center mt-1 ms-1"
              style={{ fontSize: "11px", color: "#00878c", fontWeight: "bold" }}
            >
              Days
            </h6>
          </div>
        </div>
        <hr style={{ color: "#2E323B" }} />
        <div className="d-flex justify-content-center">
          <div className="d-flex">
            <div
              style={{
                width: "auto",
                height: "auto",
                backgroundColor: "#2F3541",
                padding: "4px 6px",

                borderRadius: "4px",
              }}
            >
              <FontAwesomeIcon color="white" icon={faPlus} size="lg" />
            </div>

            <div
              style={{
                width: "auto",
                height: "auto",
                backgroundColor: "#2F3541",
                padding: "4px 6px",

                borderRadius: "4px",
                marginLeft: "20px",
              }}
            >
              <FontAwesomeIcon color="white" icon={faComment} size="lg" />
            </div>

            <div
              style={{
                width: "auto",
                height: "auto",
                backgroundColor: "#2F3541",
                padding: "4px 6px",

                marginLeft: "20px",
                borderRadius: "4px",
              }}
            >
              <FontAwesomeIcon color="white" icon={faTrashCan} size="lg" />
            </div>
          </div>
        </div>
      </div> */}
        <div className="p-3 h-100 position-relative">
          <div className="d-flex justify-content-between">
            <div className="my-auto">
              <h4 className="text-white my-auto" style={{ fontWeight: "650" }}>
                {product.title}
              </h4>
              <h6 className="text-white my-auto" style={{ paddingTop: "15px" }}>
                Webhooks
              </h6>
            </div>
            <div>
              <div
                className="mb-3"
                style={{
                  padding: "10px 24px",
                  marginTop: "20px",
                  backgroundColor: "#00878C",
                  borderRadius: "6px",
                }}
              >
                <h3
                  className="text-center m-0 d-flex align-self-center text-white"
                  style={{ fontWeight: "650", lineHeight: "28px" }}
                >
                  {product.price}
                </h3>
                <h6
                  className="text-center m-0 text-white"
                  style={{ fontWeight: "lighter" }}
                >
                  /month
                </h6>
              </div>
            </div>
          </div>
          <hr style={{ color: "#333844", height: "3px" }} />
          {product.perks.map((perks, idx) => (
            <div key={idx} className="mt-4 d-flex">
              <FontAwesomeIcon
                style={{
                  backgroundColor: "white",
                  borderRadius: "30px",
                }}
                color="#00878C"
                icon={faCheckCircle}
                size="lg"
              />
              <h6 className="ms-3 text-white" style={{ fontWeight: "350" }}>
                {perks.text}
              </h6>
            </div>
          ))}
          <div className="w-100 mt-3 d-flex justify-content-center">
            <button
              style={{
                borderRadius: "10px",
                height: "60px",
                backgroundColor: "#00878C",
                width: "100%",
                fontWeight: "bold",
                color: "white",
                border: "none",
              }}
            >
              {product.daysLeft} days left
            </button>
          </div>
          <div className="w-100 mt-3 d-flex justify-content-center text-white">
            <h6>Active</h6>
          </div>
          {/* <button
          style={{
            position: "absolute",
            bottom: 20,
            right: 28,
            borderRadius: "10px",
            height: "60px",
            backgroundColor: "#00878C",
            width: "90%",
            fontWeight: "bold",
            color: "white",
            border: "none",
          }}
        >
          Purchase
        </button> */}
        </div>
      </div>
    </div>
  );
};

export default ProductCards;
