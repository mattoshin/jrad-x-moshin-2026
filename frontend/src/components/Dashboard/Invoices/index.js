import { AllInvoices } from "./InvoiceComponents/AllInvoices";
import { MonthlyInvoices } from "./InvoiceComponents/MonthlyInvoices";
import { MonthlySpend } from "./InvoiceComponents/MonthlySpend";
import { invoices as invoicesApi } from "../../../api";
import { useState, useEffect } from "react";

const Invoices = () => {
  const [totalPaid, setTotalPaid] = useState(0);
  const [totalUnpaid, setTotalUnpaid] = useState(0);
  const [monthlyTotal, setMonthlyTotal] = useState(0);
  const [monthTotalPaid, setMonthTotalPaid] = useState(0);
  const [monthTotalUnpaid, setMonthTotalUnpaid] = useState(0);

  useEffect(()=>{
    const getData = async () => {
      const invoicesResponse = await invoicesApi();
      setTotalPaid(invoicesResponse.data.totalPaid);
      setTotalUnpaid(invoicesResponse.data.totalUnpaid);
      setMonthlyTotal(invoicesResponse.data.monthlyTotal);
      setMonthTotalPaid(invoicesResponse.data.monthTotalPaid);
      setMonthTotalUnpaid(invoicesResponse.data.monthTotalUnpaid);
    };
    getData();
  }, []);

  return (
    <div className="p-5">
      <div className="row">
        <AllInvoices />
      </div>
    </div>
  );
};

export default Invoices;
