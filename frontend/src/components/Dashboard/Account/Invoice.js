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
    <tr>
      <th scope="row">#{orderId}</th>
      <td>{user}</td>
      <td>{product}</td>
      <td>${amount}.00</td>
      <td>
        <button
          className="invoice-status"
          style={{
            height: "fit-content",
            padding: "2px 0px",
            color: status ? "#00878C" : "#FC5B5B",
            fontWeight: "500",
            fontSize: "16px",
          }}
        >
          {status ? "Paid" : "Unpaid"}
        </button>
      </td>
      <td>{moment(date).format('MMM Do, YYYY')}</td>
      <td>
        <button
          className="invoice-button"
          style={{
            height: "fit-content",
            padding: "4px 0px",
            color: "#00878C",
            fontWeight: "500",
            fontSize: "16px",
          }}
          onClick={() => nav(`/invoice/${orderId}`)}
        >
          Details
        </button>
      </td>
    </tr>
  );
};
