import { faEllipsisVertical } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { useNavigate } from "react-router-dom";
import moment from 'moment';
import "./invoice.css";
export const Invoice = ({
  orderId,
  date,
  user,
  product,
  status,
  amount,
  payment,
}) => {
  const nav = useNavigate();
  return (
    <div
      className="row mb-3 p-3 invoice"
      onClick={() => nav(`/invoice/${orderId}`)}
    >
      <div
        className="col-1  d-flex align-items-center "
        style={{ overflowX: "overlay" }}
      >
        <h6 className="text-white m-0">#{orderId}</h6>
      </div>
      <div
        className="col-2 col-md-1 d-flex align-items-center "
        style={{ overflowX: "overlay" }}
      >
        <h6 className="text-white m-0">{user}</h6>
      </div>
      <div
        className="col-3 d-flex align-item-center justify-content-center custom-table-cols-active progress-col "
        style={{ overflowX: "overlay" }}
      >
        <h6 className="text-white d-flex my-auto m-0">{product}</h6>
      </div>
      <div
        className=" col-2 col-lg-2  d-flex align-items-center  justify-content-center custom-table-cols-active progress-col  "
        style={{ overflowX: "overlay" }}
      >
        <h6 className="text-white p-0 m-0">${amount}.00</h6>
      </div>
      <div
        className=" col-2 col-lg-2 d-none d-md-block d-flex align-items-center  justify-content-center custom-table-cols-active progress-col  "
        style={{ overflowX: "overlay" }}
      >
        <h6 className="text-white p-0 m-0">Stripe</h6>
      </div>
      <div
        className="col-2 d-flex align-items-center  justify-content-center"
        style={{ overflowX: "overlay" }}
      >
        <button
          className="active-sub-button"
          style={{
            height: "fit-content",
            padding: "2px 0px",
            color: status ? "#50E34D" : "#FC5B5B",
            fontWeight: "500",
            fontSize: "16px",
          }}
        >
          {status ? "Paid" : "Unpaid"}
        </button>
      </div>
      {/* <div
        className="col-2 d-none d-lg-block custom-table-cols-active progress-col "
        style={{ overflowX: "overlay" }}
      >
        <div className=" align-items-center w-100 h-100 justify-content-center custom-table-cols-active progress-col">
          <div className="d-flex m-auto">
            <p className="w-100" style={{ color: "#fff", margin: 0 }}>
              {payment}
            </p>
          </div>
        </div>
      </div> */}

      <div className="col-1" style={{ overflowX: "overlay" }}>
        <div className="d-flex align-items-center w-100 h-100 ">
          <p style={{ color: "#666", margin: "0" }}>{moment(date).format('MMM Do, YYYY')}</p>
        </div>
      </div>
    </div>
  );
};
