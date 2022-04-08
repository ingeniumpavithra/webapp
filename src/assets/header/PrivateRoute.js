import { Navigate } from "react-router-dom";
import { useEffect } from "react";

function PrivateRoute({ children }) {
  let auth, role = null;
  if (sessionStorage.getItem("user") !== null) {
    auth = JSON.parse(sessionStorage.getItem("user"));
    role = auth.user.role;
  }
  useEffect(() => {
    if (!auth || !(role === "user")) {
      alert("You are not user!!! Please login");
    }
  }, []);
  return auth && role === "user" ? children : <Navigate to ="/" /> ;
}

export default PrivateRoute;
