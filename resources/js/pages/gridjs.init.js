/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: grid Js File
*/

if (document.querySelector("#add_link_xoi_lac")) {
    document.querySelector("#add_link_xoi_lac").addEventListener("click", function () {
        const container = document.querySelector(".row-container");
        const match_url = document.querySelector(".match-url").value;
        document.querySelector(".match-url").value = "";

        const fetchData = (url, callback) => {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    callback(JSON.parse(xhr.responseText));
                }
            };
            xhr.send();
        };

        fetchData(`/xoilac_analyst?url=${match_url}`, function (data) {
            const table_id_half1 = Date.now().toString(36) + Math.random().toString(36).substr(2, 9);
            const table_id_half2 = Date.now().toString(36) + Math.random().toString(36).substr(2, 9);
            let data_delete_match = Date.now().toString(36) + Math.random().toString(36).substr(2, 9);
            const { team_home, team_away, total_stats_indices } = data;

            // Insert HTML for the two halves
            container.insertAdjacentHTML('beforeend', `
                <div class="col-3 ${data_delete_match}">
                    <button class="btn btn-danger waves-effect waves-light delete-match ${data_delete_match}" style="width: 100%" type="button">Xoá</button>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0 flex-grow-1" >${team_home} - ${team_away} hiệp 1</h4>
                        </div>
                        <div class="card-body">
                            <div id="${table_id_half1}"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0 flex-grow-1">${team_home} - ${team_away} hiệp 2</h4>
                        </div>
                        <div class="card-body">
                            <div id="${table_id_half2}"></div>
                        </div>
                    </div>
                </div>
            `);

            document.querySelector(`button.${data_delete_match}`).addEventListener("click",function (){
                this.parentElement.remove();
            })

            // Initialize grid configurations
            const initializeTable = (elementId) => new gridjs.Grid({
                columns: [
                    { name: "Chỉ số", id:"index", width: "70px" },
                    { name: team_home, id:"team_home", width: "90px" },
                    { name: team_away, id:"team_away", width: "90px" },
                    { name: "Tổng", id:"total"}
                ],
                data: [
                    [`Tổng (${total_stats_indices})`, "loading", "loading", "loading"],
                    ["Tấn công nguy hiểm", "loading", "loading", "loading"],
                    ["Góc", "loading", "loading", "loading"]
                ],
                sort: true,
            }).render(document.getElementById(elementId));

            const tableHalf1 = initializeTable(table_id_half1);
            const tableHalf2 = initializeTable(table_id_half2);

            // Function to update the tables
            const updateTables = (response) => {
                let current_time = parseInt(response.current_time.match(/\d+/g)[0]);
                document.querySelector(`#${table_id_half1}`).parentElement.parentElement.querySelector("h4").innerText = `${response.team_home} - ${response.team_away} hiệp 1 (Phút thứ ${current_time >= 45 ? 45 : current_time})`
                document.querySelector(`#${table_id_half2}`).parentElement.parentElement.querySelector("h4").innerText = `${response.team_home} - ${response.team_away} hiệp 2 (Phút thứ ${response.current_time})`
                let stats = response.statistics;
                

                if(current_time<=45 || document.querySelector(`#${table_id_half1}`).innerHTML.toLowerCase().includes("loading")){
                    tableHalf1.updateConfig({
                        data: [
                            [`Tổng (${total_stats_indices})`, stats.total_home_stats_half1, stats.total_away_stats_half1, stats.total_home_stats_half1 + stats.total_away_stats_half1],
                            ["Tấn công nguy hiểm", stats.home_dangerous_attack_half1, stats.away_dangerous_attack_half1, stats.home_dangerous_attack_half1 + stats.away_dangerous_attack_half1],
                            ["Góc", stats.home_corners_half1, stats.away_corners_half1, stats.home_corners_half1 + stats.away_corners_half1]
                        ], columns: [
                            { name: "Chỉ số", id:"index", width: "70px" },
                            { name: response.team_home, id:"team_home", width: "90px" },
                            { name: response.team_away, id:"team_away", width: "90px" },
                            { name: "Tổng", id:"total"}
                        ],
                    }).forceRender();
                } else {
                    tableHalf2.updateConfig({
                        data: [
                            [`Tổng (${total_stats_indices})`, stats.total_home_stats_half2, stats.total_away_stats_half2, stats.total_home_stats_half2 + stats.total_away_stats_half2],
                            ["Tấn công nguy hiểm", stats.home_dangerous_attack_half2, stats.away_dangerous_attack_half2, stats.home_dangerous_attack_half2 + stats.away_dangerous_attack_half2],
                            ["Góc", stats.home_corners_half2, stats.away_corners_half2, stats.home_corners_half2 + stats.away_corners_half2]
                        ], columns: [
                            { name: "Chỉ số", id:"index", width: "70px" },
                            { name: response.team_home, id:"team_home", width: "90px" },
                            { name: response.team_away, id:"team_away", width: "90px" },
                            { name: "Tổng", id:"total"}
                        ]
                    }).forceRender();
                }
            };

            // Update tables every 5 seconds
            const interval = setInterval(function () {
                fetchData(`/xoilac_analyst?url=${match_url}`, function (response) {
                    try{
                        updateTables(response);
                    } catch (e) {
                        clearInterval(interval);
                    }
                });
                }, 5000);
        });
    });


}
