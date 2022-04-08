import axios from "axios";
import React from "react";
import { useState, useMemo, useEffect } from "react";
import { useTable ,useSortBy, usePagination } from "react-table";
import jsPDF from "jspdf";
import "jspdf-autotable";
import authHeader from "../assets/header/auth-header";
import REACT_APP_API_URL from "../assets/header/env";
const Seaters = () => {

  // const dateValue: Date = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getMonth(), 14);
 
  const [Data, setData] = useState([]);
  const getData = async () => {
    const res = await axios.get(`${REACT_APP_API_URL}/get_seaters`,{ headers: authHeader() });
    if (res) {
      const data = res.data.all;
      setData(data);
    } else {
      console.log("Error");
    }
   };
 
  useEffect(() => {
    getData();
  }, []);
 
  const tableData = useMemo(() => [...Data], [Data]);

  const tableColumns = useMemo(
    () =>
      Data[0]
        ? Object.keys(Data[0])
            .filter((key) => key !== "created_at" && key !== "updated_at")
            .map((key) => {
              return {
                Header: key.charAt(0).toUpperCase() + key.slice(1),
                accessor: key,
                maxWidth: 10,
                Cell: (props) => {
                  if (props.value) {
                    return props.value;
                  } else {
                    return <span>--</span>;
                  }
                },
              };
            })
        : [],
    [Data]
  );
  const sno = {
    Header: 'S.No',
    Accessor: 'Sno',
    Cell: ({ row }) => {
      return row.index+1;
    },
  }
  tableColumns.unshift(sno);
  const {
    getTableProps,
    getTableBodyProps,
    headerGroups,
    page,
    prepareRow, 
      canPreviousPage,
    canNextPage,
    pageOptions,
    pageCount,
    gotoPage,
    nextPage,
    previousPage,
    setPageSize,
    state: { pageIndex, pageSize },
  } = useTable({
    columns: tableColumns,
    data: tableData,
    initialState: { pageIndex: 0 },
  },
  useSortBy,
  usePagination
  );

  function exportpdf() {
    console.log("Saving report as pdf");
    const unit = "pt";
    const size = "A4"; // Use A1, A2, A3 or A4
    const orientation = "landscape"; // portrait or landscape
    const marginLeft = 40;
    const doc = new jsPDF(orientation, unit, size);
    doc.setFontSize(20);
    const title = "TRIP DETAILS - 7_seaters";
    const headers = [
      [
        "SNO",
        "DATE",
        "TIME",
        "CUSTOMER NAME",
        "MOBILE",
        "KM_RS",
        "DISTANCE",
        "TOLLS",
        "EXTRA_DESC",
        "EXTRA_AMT",
        "DISCOUNT",
        "TOTAL",],
    ];
    console.log(Data);
    const data = Data.map((row,i) => [
      i+1,
      row.date,
      row.time,
      row.customer,
      row.mobile,
      row.kmrupees,
      row.distance,
      row.tollcharge,
      row.xtra_desc,
      row.xtracharge,
      row.discount,
      row.total ,
    ]);
    let content = {
      startY: 50,
      head: headers,
      body: data,
    };
    doc.text(title, marginLeft, 40);
    doc.autoTable(content);
    doc.save("report.pdf");
  }
  
  const [start_date, setstart_date] = useState("");
  const [end_date, setend_date] = useState("");


 
  function start_dateHandler(e) {
    setstart_date(e.target.value);
  }
  function end_dateHandler(e) {
    setend_date(e.target.value);
  }


  const getsearch = async () => {
    try{  
      const response = await axios.post(`${REACT_APP_API_URL}/get_search` ,{
        start_date: start_date,
        end_date: end_date
      }, { headers: authHeader() });
      if (response.data.data) {
        console.log(response.data)
        setData(response.data.data);
      }
    
    }catch(e){
      console.log(e);
      alert("Something went wrong..!");
    }
  
  };
  

  return (
    <div className="flex-grow-1">
     
     
     <h3 className="text-center mt-3">7 Seaters Trip details</h3>
     <br />
     <div className="row no-gutters" >
   
     <div className="col-md-3" style={{marginLeft:20}} >
     <label className="mt-2 mb-1" htmlFor={""}>
                                      From Date :
                                    </label>
          <input type="date" className={`form-control mb-2  border border-warning`} placeholder="start_date" id="start_date" name="start_date" 
          format="dd-MMM-yyyy" value={start_date} onChange={start_dateHandler} />
     </div>
     <div className="col-md-3" text-align="center">
     <label className="mt-2 mb-1" htmlFor={""}>
                                      To Date :
                                    </label>
     <input type="date" className={`form-control mb-2 border border-warning`} placeholder="end_date" id="end_date" name="end_date"
       format="dd-MMM-yyyy" value={end_date} onChange={end_dateHandler} /> 
      </div>
      <div className="col-md-3" >
      <button  style={{ width: "25px", height: "40px", minWidth: "150px", marginTop: "35px"}} className="btn btn-warning" onClick={getsearch}> SEARCH  </button>
      </div>
     </div>
     <br/>
    <hr></hr>
      <table className="table table-striped  m-auto" {...getTableProps()}>
        <thead>
          {headerGroups.map((headerGroup) => (
            <tr className="text-center" {...headerGroup.getHeaderGroupProps()}>
              {headerGroup.headers.map((column) => (
                <th className="px-3 " {...column.getHeaderProps(column.getSortByToggleProps())}>{column.render("Header")}
                 <span >
                    {column.isSorted
                      ? column.isSortedDesc
                        ? ' 🔽'
                        : ' 🔼'
                      : ''}
                  </span>
                </th>
              ))}
            </tr>
          ))}
        </thead>
        <tbody {...getTableBodyProps()}>
          {page.map((row, i) => {
            prepareRow(row);
            return (
              <tr  className="text-center" {...row.getRowProps()}>
                {row.cells.map((cell) => {
                  return (
                    <td {...cell.getCellProps()}>
                      {cell.column.Header === "Id"
                        ? cell.row.index + 1
                        : cell.render("Cell")}
                    </td>
                  );
                })}
              </tr>
            );
          })}
        </tbody>
      </table>
      <div className="p-3 mx-3 text-center">
      <button className="btn btn-primary me-2" onClick={()=> exportpdf()}>
          export as pdf
        </button>
        <button onClick={() => gotoPage(0)} disabled={!canPreviousPage}>
          {'<<'}
        </button>{' '}
        <button onClick={() => previousPage()} disabled={!canPreviousPage}>
          {'<'}
        </button>{' '}
        <button onClick={() => nextPage()} disabled={!canNextPage}>
          {'>'}
        </button>{' '}
        <button onClick={() => gotoPage(pageCount - 1)} disabled={!canNextPage}>
          {'>>'}
        </button>{' '}
        <span>
          Page{' '}
          <strong>
            {pageIndex + 1} of {pageOptions.length}
          </strong>{' '}
        </span>
        <span>
          | Go to page:{' '}
          <input
            type="number"
            defaultValue={pageIndex + 1}
            onChange={e => {
              const page = e.target.value ? Number(e.target.value) - 1 : 0
              gotoPage(page)
            }}
            style={{ width: '100px' }}
          />
        </span>{' '}
        <select
          value={pageSize}
          onChange={e => {
            setPageSize(Number(e.target.value))
          }}
        >
          {[10, 20, 30, 40, 50].map(pageSize => (
            <option key={pageSize} value={pageSize}>
              Show {pageSize}
            </option>
          ))}
        </select>
        
      </div>
      <hr></hr>
,
    </div>
    
  );
};
export default Seaters;
