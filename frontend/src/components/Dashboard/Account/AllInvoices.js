import { Invoice } from "./Invoice";
import {
  faArrowDown19,
  faBoxesStacked,
  faSearch,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { invoices as invoicesApi } from "../../../api";
import { InvoiceCard } from "./InvoiceCard";
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
    <>
      <div className="d-flex justify-content-between p-3">
        <div className="my-auto">
          
          <h5 
            className="text-white" 
            style={{
              marginTop: "40px",
              fontSize: "22px",
              fontWeight: "600"
            }}
          >Payment History</h5> 
          
          <p 
            style={{
              color: "#acacac"
            }}
          >View your last 5 payments</p> 
        </div>
      </div>
      <div>
          <div
            className="ps-3 pe-3 "
            style={{
              marginTop: "16px",
              marginBottom:"5px",
              backgroundColor: "#1e222b",
              position: "sticky",
              top: 0,
              zIndex: "1000 !important",
            }}
          >
            <div className="row ">
              <div
                style={{ fontWeight: "lighter" }}
                className="custom-table-cols-active product-col col-1 col-lg-1"
              >
                <h6 className="text-white" style={{ fontWeight: "lighter" }}>
                  Order #
                </h6>
              </div>
              <div
                style={{ fontWeight: "lighter" }}
                className="custom-table-cols-active product-col col-2 col-lg-2  d-none d-md-block"
              >
                <h6 className="text-white" style={{ fontWeight: "lighter" }}>
                  Billing Name
                </h6>
              </div>
              <div
                style={{ fontWeight: "lighter" }}
                className="custom-table-cols-active product-col col-2 col-lg-2"
              >
                <h6 className="text-white" style={{ fontWeight: "lighter" }}>
                  Product Name
                </h6>
              </div>
              <div className="custom-table-cols-active progress-col col-2">
                <h6 className="text-white" style={{ fontWeight: "lighter" }}>Amount</h6>
              </div>

              <div className="custom-table-cols-active status-col col-3">
                <h6 className="text-white" style={{ fontWeight: "lighter" }}>
                  Status
                </h6>
              </div>
              <div className="custom-table-cols-active product-col col-2">
                <h6 className="text-white" style={{ fontWeight: "lighter" }}>
                  Purchase Date
                </h6>
              </div>
            </div>
          </div>
          <div className="mt-1 cards-holder-active" style={{height: "100%"}}>
            {invoices.map((invoice)=>{
              return (
                <InvoiceCard 
                  key={invoice.id} 
                  id={invoice.id} 
                  product_name={invoice.product.name} 
                  billing_name={invoice.billing_name} 
                  payment_amount={invoice.payment_amount}
                  date={invoice.creation_date}
                  status={invoice.paid}
                />
              )
            })}
          </div>
        </div>
    </>

  );
};
