
import { invoices as invoicesApi } from "../../../../api";
import { useState, useEffect } from "react";
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  Filler,
} from "chart.js";
import { Line } from "react-chartjs-2";

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  Filler
);
export const MonthlyInvoices = () => {
  const [invoices, setInvoices] = useState([]);
  useEffect(()=>{
    const getData = async () => {
      const invoicesResponse = await invoicesApi();
      setInvoices(invoicesResponse.data.chart_data);
    };
    getData();
  }, []);

  var data = {
    labels: invoices.map(item => { return item.month;}),
    datasets: [
      {
        label: "Invoices",
        data: invoices.map(item => { return item.total_amount;}),
        fill: true,
        pointRadius: 0,
        borderColor: "#00878C",
        smooth: true,
        fill: true,
        backgroundColor: "rgb(0, 135, 140, 8%)",
        lineTension: 0.4,
        borderWidth: 2
      },
    ],
  };

  const options = {
    interaction: {
      mode: "index",
      intersect: false,
    },
    maintainAspectRatio: false,
    responsive: true,
    fill: true,
    plugins: {
      legend: {
        position: "top",
      },
      title: {
        display: true,
        text: "Monthly Invoices",
        color: "white",
      },
    },
    scales: {
      margin: 0,
      padding: 0,
      x: {
        gridLines: {
          display: false,
        },
      },
      y: {
        ticks: {
          stepSize: 2000,
        },

        margin: 0,
        padding: 0,
      },
    },
  };

  return (
    <div style={{ height: "240px" }} className=" col-md-12 col-lg-7 p-3">
      <div className="main-card p-3">
        <Line height={"auto"} width={"auto"} options={options} data={data} />
      </div>
    </div>
  );
};
