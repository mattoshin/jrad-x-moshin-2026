import { faEllipsisVertical } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import moment from 'moment';
import { useNavigate } from "react-router-dom";

export const InvoiceCard = (props) => {
  const nav = useNavigate();
  return (
    <div
      className="row mb-1 invoice-sub" onClick={() => nav(`/invoice/${props.id}`)}
    >
      <div
        className="col-1 col-lg-1 d-flex align-items-center "
        style={{ overflowX: "overlay" }}
      >
        <h6 className="text-white ">#{props.id}</h6>
      </div>
      <div
        className="col-2 col-lg-2 mt-1 d-flex align-items-center d-none d-md-block "
        style={{ overflowX: "overlay" }}
      >
        <h6 className="text-white ">{props.billing_name}</h6>
      </div>
      <div
        className="col-2 col-lg-2 d-flex align-items-center "
        style={{ overflowX: "overlay" }}
      >
        <h6 className="text-white ">{props.product_name}</h6>
      </div>
      <div className="col-2 p-0" style={{ overflowX: "overlay" }}>
        <div className="d-flex align-items-center w-100 h-100 justify-content-center">
          <div className="d-flex">
            <p style={{ color: "#fff", margin: 0 }}>{`$${props.payment_amount}.00`}</p>
          </div>
        </div>
      </div>
      <div
        className="col-3 d-flex align-items-center  justify-content-center"
        style={{ overflowX: "overlay" }}
      >
        <button
          style={{ 
            height: "fit-content", 
            padding: "2px 0px",
            color: props.status ? "#50E34D" : "#FC5B5B",
          }}
          className="active-sub-button"
        >
          {props.status? 'Paid': 'Unpaid'}
        </button>
      </div>
      
      <div className="col-2" style={{ overflowX: "overlay" }}>
        <div
          className="d-flex align-items-center w-100 h-100 "
        >
          <p style={{ color: "#666", margin: "0" }}>{moment(props.date).format('MMM Do, YYYY')}</p>
        </div>
      </div>
    </div>
  );
};
