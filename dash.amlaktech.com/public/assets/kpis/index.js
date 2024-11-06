class LocaleCache {
    constructor() {
        this.cache = {}
    }

    // Method
    isCashed(key) {
        return key in this.cache
    }

    get(key) {
        if (key in this.cache) return this.cache[key]
        return null
    }

    set(key, value) {
        this.cache[key] = value
    }
}

const cache = new LocaleCache()
const baseURL = "https://app.mabet.com.sa/dashboard"

const MabetKPIs = axios.create({
    baseURL,
})

// Append '4d' to the colors (alpha channel), except for the hovered index
function handleHover(evt, item, legend) {
    const color = legend.chart.data.datasets[item.datasetIndex].backgroundColor
    legend.chart.data.datasets[item.datasetIndex].backgroundColor = color + "4D"
    legend.chart.update()
}

// Removes the alpha channel from background colors
function handleLeave(evt, item, legend) {
    const color = legend.chart.data.datasets[item.datasetIndex].backgroundColor
    legend.chart.data.datasets[item.datasetIndex].backgroundColor = color.slice(0, -2)
    legend.chart.update()
}

// chart default options
const defaultOptions = {
        responsive: true,

        animation: {
            duration: 1000, // duration of the animation in ms
            easing: "easeInOutQuad", // easing function
        }, interaction: {
            intersect: false, mode: "index",
        }, scales: {
            y: {
                beginAtZero: true,
            },
        },
    }

;(async () => {
    const statisticsMap = {
        all_bookings_count: {
            label: "اجمالي عدد الحجوزات", icon: "/assets/kpis/assets/calendar-days.svg",
        },
        active_bookings: {
            label: "حجوزات فعالة", icon: "/assets/kpis/assets/calendar-clock.svg",
        },
        active_bookings_nights: {
            label: "اجمالي الليالي المحجوزة", icon: "/assets/kpis/assets/calendar-days.svg",
        },
        active_last_24_visitors: {
            label: " الزائرين خلال 24 ساعة", icon: "/assets/kpis/assets/user-round-plus.svg",
        },
        cancelled_bookings: {
            label: "الحجوزات الملغاه", icon: "/assets/kpis/assets/calendar-x.svg",
        },
        expired_bookings: {
            label: "حجوزات منتهية", icon: "/assets/kpis/assets/calendar-check.svg",
        },
        active_units: {label: "الوحدات الفعالة", icon: "/assets/kpis/assets/activity.svg"},
        active_visitors: {
            label: "العملاء النشطين", icon: "/assets/kpis/assets/user-round-pen.svg",
        },

        all_units: {label: "اجمالي عدد الوحدات", icon: "/assets/kpis/assets/building-2.svg"},
        all_users: {label: "عدد العملاء", icon: "/assets/kpis/assets/users.svg"},

        licensed_units: {
            label: "الوحدات المرخصة", icon: "/assets/kpis/assets/user-check.svg",
        },
        linked_units: {label: "عقارات مربوطه", icon: "/assets/kpis/assets/link.svg"},
        partners_count: {label: "اجمالي الشركاء", icon: "/assets/kpis/assets/handshake.svg"},
        verified_users: {
            label: "مستخدمين موثقين", icon: "/assets/kpis/assets/user-check.svg",
        },
    }

    const statistics = document.getElementById("statistics")
    // ;(async () => {
    try {
        const response = await MabetKPIs.get("/kpis")

        const fragment = document.createDocumentFragment()
        Object.entries(response.data.data).forEach(([key, value]) => {
            if (typeof statisticsMap[key] === "undefined") return null
            const card = document.createElement("div")
            card.className = "statistic-card"
            card.innerHTML = `
       <div class="icon">
                <img src="${statisticsMap[key].icon}" alt="icon" />
              </div>
              <p class="label">${statisticsMap[key].label}</p>
              <span>${value}</span>
      `
            fragment.appendChild(card)
        })

        statistics.appendChild(fragment)
    } catch (error) {
        console.log("🚀 ~ getGeneratedStatistics ~ error:", error)
    }
    // })()

    // total sales chart
    let totalSalesChart = null

    const GetTotalSales = async (period = "week") => {
        if (cache.isCashed(`total-sales-${period}`)) {
            return cache.get(`total-sales-${period}`)
        }
        const response = await MabetKPIs.get(`/kpis/total-sales`, {
            params: {
                period,
            },
        })

        cache.set(`total-sales-${period}`, response.data.data)

        return response.data.data
    }
    const generateTotalSalesChart = async (fetcher) => {
        const totalSalesChartElement = document.getElementById("total-sales-chart")
        try {
            const data = await fetcher("week")
            // if (totalSalesChart) totalSalesChart.destroy()
            totalSalesChart = new Chart(totalSalesChartElement, {
                type: "line", data: {
                    labels: data.map((e) => e.xAxis), datasets: [{
                        label: "اجمالي الارباح", data: data.map((e) => e.yAxis), fill: false,

                        borderColor: "#4ebeb1", tension: 0.1, fill: true, hoverBackgroundColor: "#4ebeb1",
                    },],
                }, options: defaultOptions,
            })
        } catch (error) {
            console.log("🚀 ~ generateTotalSalesChart ~ error:", error)
        }
    }

    const totalSalesFiler = document.querySelectorAll('input[name="total-sales-filter"]')

    const handleTotalSalesFilter = async (event) => {
        const selectedValue = event.target.value
        try {
            const data = await GetTotalSales(selectedValue)
            totalSalesChart.data.datasets[0].data = data.map((e) => e.yAxis)

            // Optionally update labels if needed
            totalSalesChart.data.labels = data.map((e) => e.xAxis)

            // Smoothly update the chart
            totalSalesChart.update()
        } catch (error) {
            console.log("🚀 ~ handleTotalSalesFilter ~ error:", error)
        }
    }

    totalSalesFiler.forEach((radio) => {
        radio.addEventListener("change", handleTotalSalesFilter)
    })

    await generateTotalSalesChart(GetTotalSales)

    // profitsChart chart
    let profitsChart = null

    const GetProfits = async (period = "week") => {
        if (cache.isCashed(`profits-${period}`)) {
            return cache.get(`profits-${period}`)
        }
        const response = await MabetKPIs.get(`/kpis/profits`, {
            params: {
                period,
            },
        })

        cache.set(`profits-${period}`, response.data.data)
        return response.data.data
    }
    const generateProfitsChart = async (fetcher) => {
        const profitsChartElement = document.getElementById("profits-chart")
        try {
            const data = await fetcher("week")
            console.log("🚀 ~ generateProfitsChart ~ data:", data)
            // if (totalSalesChart) totalSalesChart.destroy()
            profitsChart = new Chart(profitsChartElement, {
                type: "line", data: {
                    labels: data.map((e) => e.xAxis), datasets: [{
                        label: "اجمالي الارباح", data: data.map((e) => e.yAxis), fill: false,

                        borderColor: "#4ebeb1", tension: 0.1, fill: true, hoverBackgroundColor: "#4ebeb1",
                    },],
                }, options: defaultOptions,
            })
        } catch (error) {
            console.log("🚀 ~ generateProfitsChart ~ error:", error)
        }
    }

    const profitsFilter = document.querySelectorAll('input[name="profits-filter"]')

    const handleProfitsChange = async (event) => {
        const selectedValue = event.target.value
        try {
            const data = await GetProfits(selectedValue)
            profitsChart.data.datasets[0].data = data?.map((e) => e.yAxis)

            // Optionally update labels if needed
            profitsChart.data.labels = data?.map((e) => e.xAxis)

            // Smoothly update the chart
            profitsChart.update()
        } catch (error) {
            console.log("🚀 ~ handleProfitsChange ~ error:", error)
        }
    }

    profitsFilter.forEach((radio) => {
        radio.addEventListener("change", handleProfitsChange)
    })

    await generateProfitsChart(GetProfits)

    // unitsChart chart
    let unitsChart = null

    const GetUnits = async (period = "week") => {
        if (cache.isCashed(`units-${period}`)) {
            return cache.get(`units-${period}`)
        }
        const response = await MabetKPIs.get(`/kpis/units`, {
            params: {
                period,
            },
        })

        cache.set(`units-${period}`, response.data.data)

        return response.data.data
    }

    const generateUnitsChart = async (fetcher) => {
        const unitsChartElement = document.getElementById("units-chart")
        try {
            const data = await fetcher("week")
            console.log("🚀 ~ generateUnitsChart ~ data:", data)
            // if (totalSalesChart) totalSalesChart.destroy()
            unitsChart = new Chart(unitsChartElement, {
                type: "bar", data: {
                    labels: data.map((e) => e.xAxis), datasets: [{
                        label: "اجمالي الوحدات",
                        data: data.map((e) => e.yAxis),
                        fill: false,
                        backgroundColor: "#4ebeb1",
                        borderColor: "#4ebeb1",
                        tension: 0.1,
                        fill: true,
                        hoverBackgroundColor: "#4ebeb1",
                    },],
                }, options: defaultOptions,
            })
        } catch (error) {
            console.log("🚀 ~ generateUnitsChart ~ error:", error)
        }
    }

    const unitsFilter = document.querySelectorAll('input[name="units-filter"]')

    const handleUnitsFilterChange = async (event) => {
        const selectedValue = event.target.value
        try {
            const data = await GetUnits(selectedValue)
            unitsChart.data.datasets[0].data = data?.map((e) => e.yAxis)

            // Optionally update labels if needed
            unitsChart.data.labels = data?.map((e) => e.xAxis)

            // Smoothly update the chart
            unitsChart.update()
        } catch (error) {
            console.log("🚀 ~ handleUnitsFilterChange ~ error:", error)
        }
    }

    unitsFilter.forEach((radio) => {
        radio.addEventListener("change", handleUnitsFilterChange)
    })

    await generateUnitsChart(GetUnits)
    // bookingsChart chart
    let bookingsChart = null

    const GetBookings = async (period = "week") => {
        if (cache.isCashed(`bookings-${period}`)) {
            return cache.get(`bookings-${period}`)
        }
        const response = await MabetKPIs.get(`/kpis/bookings`, {
            params: {
                period,
            },
        })

        cache.set(`bookings-${period}`, response.data.data)

        return response.data.data
    }

    const generateBookingsChart = async (fetcher) => {
        const bookingsChartElement = document.getElementById("bookings-chart")
        try {
            const data = await fetcher()
            console.log("🚀 ~ generateBookingsChart ~ data:", data)
            // if (totalSalesChart) totalSalesChart.destroy()
            bookingsChart = new Chart(bookingsChartElement, {
                type: "bar", data: {
                    labels: data.labels, datasets: data.dataset, // datasets: [
                    //   {
                    //     label: "اجمالي الوحدات",
                    //     data: data.map((e) => e.yAxis),
                    //     fill: false,
                    //     backgroundColor: "#4ebeb1",
                    //     borderColor: "#4ebeb1",
                    //     tension: 0.1,
                    //     fill: true,
                    //     hoverBackgroundColor: "#4ebeb1",
                    //   },
                    // ],
                }, options: {
                    ...defaultOptions, plugins: {
                        legend: {
                            onHover: handleHover, onLeave: handleLeave,
                        },
                    }, scales: {
                        x: {
                            stacked: true,
                        }, y: {
                            stacked: true, beginAtZero: true,
                        },
                    },
                },
            })
        } catch (error) {
            console.log("🚀 ~ generateBookingsChart ~ error:", error)
        }
    }

    const generateProgressChart = async (fetcher) => {
        const bookingsChartElement = document.getElementById("progress-chart")
        try {
            const data = await fetcher()
            console.log("🚀 ~ generateBookingsChart ~ data:", data)
            // if (totalSalesChart) totalSalesChart.destroy()
            bookingsChart = new Chart(bookingsChartElement, {
                type: "bar", data: {
                    labels: data.labels, datasets: data.dataset, // datasets: [
                    //   {
                    //     label: "اجمالي الوحدات",
                    //     data: data.map((e) => e.yAxis),
                    //     fill: false,
                    //     backgroundColor: "#4ebeb1",
                    //     borderColor: "#4ebeb1",
                    //     tension: 0.1,
                    //     fill: true,
                    //     hoverBackgroundColor: "#4ebeb1",
                    //   },
                    // ],
                }, options: {
                    ...defaultOptions, plugins: {
                        legend: {
                            onHover: handleHover, onLeave: handleLeave,
                        },
                    }, scales: {
                        x: {
                            stacked: true,
                        }, y: {
                            stacked: true, beginAtZero: true,
                        },
                    },
                },
            })
        } catch (error) {
            console.log("🚀 ~ generateBookingsChart ~ error:", error)
        }
    }

    const bookingsFilter = document.querySelectorAll('input[name="bookings-filter"]')

    const handleBookingsFilterChange = async (event) => {
        const selectedValue = event.target.value
        try {
            const data = await GetBookings(selectedValue)
            bookingsChart.data.datasets = data.dataset

            // Optionally update labels if needed
            bookingsChart.data.labels = data.labels

            // Smoothly update the chart
            bookingsChart.update()
        } catch (error) {
            console.log("🚀 ~ handleBookingsFilterChange ~ error:", error)
        }
    }

    bookingsFilter.forEach((radio) => {
        radio.addEventListener("change", handleBookingsFilterChange)
    })

    await generateBookingsChart(GetBookings)
    await generateProgressChart(GetBookings)
})()
