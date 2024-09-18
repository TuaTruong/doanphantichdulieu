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
                <div class="col-3">
                    <button class="btn btn-danger waves-effect waves-light delete-match" style="display:inline" type="button">Xoá</button>
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

            document.querySelector("button.delete-match").addEventListener("click",function (){
                this.parentElement.remove();
            })

            // Initialize grid configurations
            const initializeTable = (elementId) => new gridjs.Grid({
                columns: [
                    { name: "Chỉ số", width: "90px" },
                    { name: team_home, width: "100px" },
                    { name: team_away, width: "100px" },
                    { name: "Tổng" }
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
                document.querySelector(`#${table_id_half1}`).parentElement.parentElement.querySelector("h4").innerText = `${response.team_home} - ${response.team_away} hiệp 1 (Phút thứ ${response.current_time})`
                document.querySelector(`#${table_id_half2}`).parentElement.parentElement.querySelector("h4").innerText = `${response.team_home} - ${response.team_away} hiệp 2 (Phút thứ ${response.current_time})`
                let stats = response.statistics;
                tableHalf1.updateConfig({
                    data: [
                        [`Tổng (${total_stats_indices})`, stats.total_home_stats_half1, stats.total_away_stats_half1, stats.total_home_stats_half1 + stats.total_away_stats_half1],
                        ["Tấn công nguy hiểm", stats.home_dangerous_attack_half1, stats.away_dangerous_attack_half1, stats.home_dangerous_attack_half1 + stats.away_dangerous_attack_half1],
                        ["Góc", stats.home_corners_half1, stats.away_corners_half1, stats.home_corners_half1 + stats.away_corners_half1]
                    ]
                }).forceRender();

                tableHalf2.updateConfig({
                    data: [
                        [`Tổng (${total_stats_indices})`, stats.total_home_stats_half2, stats.total_away_stats_half2, stats.total_home_stats_half2 + stats.total_away_stats_half2],
                        ["Tấn công nguy hiểm", stats.home_dangerous_attack_half2, stats.away_dangerous_attack_half2, stats.home_dangerous_attack_half2 + stats.away_dangerous_attack_half2],
                        ["Góc", stats.home_corners_half2, stats.away_corners_half2, stats.home_corners_half2 + stats.away_corners_half2]
                    ]
                }).forceRender();
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
