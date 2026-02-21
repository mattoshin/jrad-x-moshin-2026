import { faEllipsisVertical } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import "../styles.css?v=1.001";
import logo from "../../../../assets/logo.png";
import { useNavigate } from "react-router-dom";

const ActiveSubCard = (props) => {
  const nav = useNavigate();
  return (
    <div className="row mb-1 active-product-sub" onClick={() => nav(`/manage/${props.id}`)}>
      <div
        className="col-3 col-md-4 align-items-center d-flex"
        style={{ overflowX: "overlay" }}
      >
        <div>
          <img
            className="product-image"
            style={{ borderRadius: "6px" }}
            height="40"
            width="40"
            src={logo}
          />
        </div>
        <h6 className="text-white product-name m-0">{props.name}</h6>
      </div>
      <div className="col-2 col-sm-2 col-md-2 col-lg-2" style={{ overflowX: "overlay" }}>
        <div className="d-flex align-items-center h-100 justify-content-center">
          <div className="d-flex">
            <h6 className="text-white d-flex ms-3 m-0">{props.price > 0 ? `$${props.price}.00` : 'Free'}</h6>
            <h6
              className="d-flex m-0 align-self-center mt-1 ms-1"
              style={{ fontSize: "11px", color: "#00878c", fontWeight: "bold" }}
            >
              /mo
            </h6>
          </div>
        </div>
      </div>
      <div className="col-4 col-sm-4 col-md-3 col-lg-3" style={{ overflowX: "overlay" }}>
        <div className="d-flex align-items-center w-100 h-100 justify-content-center">
          {/* <div className="progress active-sub-card-progress ms-2">
            <div
              className="progress-bar active-sub-card-progress-right"
              role="progressbar"
              aria-valuenow="25"
              aria-valuemin="0"
              aria-valuemax="100"
            ></div>
          </div> */}
          <div className="d-flex">
            <h6 className="text-white d-flex ms-3 m-0">{props.cancel ? 'Plan ends in ' : ''}{props.days_left < 1000 ? props.days_left : '∞' }</h6>
            <h6
              className="d-flex m-0 align-self-center mt-1 ms-1"
              style={{ fontSize: "11px", color: "#00878c", fontWeight: "bold" }}
            >
              {props.cancel ? 'days' : 'days left'}
            </h6>
          </div>
        </div>
      </div>
      <div
        className="col-3 col-md-2 d-flex align-items-center justify-content-center"
        style={{ overflowX: "overlay" }}
      >
        <button className="active-sub-button" style={{color:props.trial ? "#FFA23A" : "#50E34D"}}>{props.trial ? "Free Trial" : "Active"}</button>
      </div>
    </div>
  );
};
export default ActiveSubCard;
