import { Invoice } from "../Invoice";
import {
  faArrowDown19,
  faBoxesStacked,
  faSearch,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { invoices as invoicesApi } from "../../../../api";
import { useState, useEffect } from "react";


export const AllInvoices = () => {
  const [invoices, setInvoices] = useState([]);
  useEffect(()=>{
    const getData = async () => {
      const invoicesResponse = await invoicesApi();
      setInvoices(invoicesResponse.data.invoices);
    };
    getData();
  }, []);

  return (
    <div className="main-cards-wrapper col-12 p-2">
      <div>
        <div className="main-wrapper-up">
          <div className="d-flex justify-content-between p-3">
            <div className="my-auto">
              <h5 className="text-white my-auto">Invoices</h5>
            </div>
            <div className="d-flex right-side-products">
              <div
                style={{
                  height: "100%",
                  width: "150px",
                  backgroundColor: "#1E222B",
                  borderRadius: "4px",
                  display: "flex",
                }}
              >
                <FontAwesomeIcon
                  className="my-auto ms-2"
                  color="white"
                  icon={faSearch}
                  size="sm"
                />
                <input
                  className="input-products"
                  type="text"
                  placeholder="Search"
                  style={{
                    height: "100%",
                    width: "100%",
                    outline: "none",
                    backgroundColor: "#1E222B",
                    paddingLeft: "15px",
                    border: "none",
                    color: "red !important",
                  }}
                />
              </div>

              <div
                className="dropdown ms-3 d-flex"
                style={{
                  height: "100%",
                  width: "150px",
                }}
              >
                <button
                  className="btn w-100 h-100 align-items-center justify-self-center d-flex justify-content-between mx-auto my-auto btn-secondary dropdown-button dropdown-toggle"
                  type="button"
                  id="dropdownMenuButton"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  Sort by
                </button>
                <div className="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a className="dropdown-item" href="#">
                    Action
                  </a>
                  <a className="dropdown-item" href="#">
                    Another action
                  </a>
                  <a className="dropdown-item" href="#">
                    Something else here
                  </a>
                </div>
              </div>
              

            </div>
          </div>
        </div>
        <div
          className="ps-3 pe-3 "
          style={{
            marginTop: "7px",
            position: "sticky",
            top: 0,
            zIndex: "1000 !important",
          }}
        >
          <div className="row">
            <div
             
              className="custom-table-cols-active product-col col-1"
            >
              <h6 className="text-white">
                Order Id
              </h6>
            </div>
            <div className="custom-table-cols-active product-col col-2 col-md-1">
              <h6 className="text-white">
                User
              </h6>
            </div>

            <div className="custom-table-cols-active progress-col col-3">
              <h6 className="text-white">Product</h6>
            </div>
            <div className="custom-table-cols-active progress-col col-2 col-lg-2">
              <h6 className="text-white">
                Amount
              </h6>
            </div>
            <div className="custom-table-cols-active progress-col col-2 col-lg-2 d-none d-md-block">
              <h6 className="text-white">
                Payment Gateway
              </h6>
            </div>
            <div className="custom-table-cols-active progress-col col-2">
              <h6 className="text-white">Status</h6>
            </div>

            {/* <div className="custom-table-cols-active status-col col-2 px-3 px-lg-2 d-none d-lg-block ">
              <h6 className="text-white" style={{ fontWeight: "lighter" }}>
                Payment
              </h6>
            </div> */}
            <div className="custom-table-cols-active product-col col-1">
              <h6 className="text-white">
                Date
              </h6>
            </div>
          </div>
        </div>
        <div
          className="mt-1 cards-holder-active"
          style={{
            overflowX: "hidden",
          }}
        >
          {invoices.map((invoice) => {
            return (
              <Invoice
                key={invoice.id}
                orderId={invoice.id}
                date={invoice.creation_date}
                user={invoice.billing_name}
                product={invoice.product.name}
                status={invoice.paid}
                amount={invoice.payment_amount}
                payment={invoice.payment_method}
              />
            );
          })}
        </div>
      </div>
    </div>
  );
};
