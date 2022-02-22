function Welcome() {
  const [e, t] = React.useState(null),
    [n, a] = React.useState(!0),
    [l, u] = React.useState(!1);
  return (
    React.useEffect(() => {
      !(function () {
        const e = document.getElementById("x_no_rujukan");
        e.addEventListener("input", () => {
          "" != e.value ? (a(!1), t(e.value)) : a(!0);
        });
      })();
    }, []),
    React.createElement(
      "div",
      null,
      React.createElement(
        "button",
        {
          type: "button",
          className: "btn btn-primary btn-small",
          disabled: n,
          onClick: async function () {
            if (
              (a(!0),
              u(!0),
              "" == document.getElementById("x_no_rujukan").value)
            )
              alert("Masukan nomor rujukan dahulu!");
            else {
              const t = await axios
                .get("http://localhost/bpjs/api/view/sep/" + e)
                .then((e) => e.data);
              t.success
                ? ((document.getElementById("x_no_sep").value = t.sep.no_sep),
                  a(!1),
                  u(!1))
                : (alert("Nomor rujukan tidak ditemukan"), a(!1), u(!1));
            }
          },
          style: { width: 98 },
        },
        l
          ? React.createElement(
              "span",
              {
                className: "fa fa-spinner fa-spin",
                style: { width: 20, textAlign: "center" },
              },
              ""
            )
          : "Ambil SEP"
      )
    )
  );
}
$("#r_no_rujukan .col-sm-10").append('<div id="ambilsep"></div>'),
  ReactDOM.render(
    React.createElement(Welcome, null, null),
    document.getElementById("ambilsep")
  );
