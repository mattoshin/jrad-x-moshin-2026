import { Outlet } from "react-router-dom";
import { useEffect, useState } from "react";

const Layout = (props, { children }) => {
  const [isSidebarOpen, setIsSidebarOpen] = useState(true);

  useEffect(() => {
    //Makes sure sidebar is closed when app first opens on smaller screens
    if (window.innerWidth <= 856) {
      setIsSidebarOpen(false);
    }

    //Ensures sidebar stays open on bigger screens
    window.addEventListener("resize", () => {
      if (window.innerWidth > 768) {

        setIsSidebarOpen(true);
      }
    });

    return () =>
      window.removeEventListener("resize", () => {
        if (window.innerWidth > 768) {
  
          setIsSidebarOpen(true);
        }
      });
  }, []);

  return (
    <>
      <div
        style={{
          transition: "width 0.5s",
          height: "100vh",
          overflow: "auto",
          backgroundColor: "#171a23",
          paddingTop: "50px",
        }}
      >
        <Outlet />
      </div>
    </>
  );
};

export default Layout;
