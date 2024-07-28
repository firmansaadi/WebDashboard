<template>
    <nav class="navbar-vertical navbar">
        <div class="nav-scroller">
            <!-- Brand logo -->
            <a class="navbar-brand" href="../index.html">
                <img src="../assets/images/brand/logo/logo.svg" alt="" />
            </a>
            <!-- Navbar nav -->
            <ul
                class="navbar-nav flex-column"
                id="sideNavbar"
                v-html="sidemenu"
                ref="sideNavbar"
                @click="handleClick"
            ></ul>
        </div>
    </nav>
</template>
<script>
import feather from "feather-icons";
import $ from "jquery";
import { ref } from "vue";

const sideMenu = [
    // { label: "Dashboard", url: "/dashboard-admin", icon: "home" },
    { label: "Dashboard", url: "/admin/dashboard", icon: "home" },
    { label: "Transaction" },
    /* { label: "Cek Status", url: "/cek", icon: "layers" },
    { label: "Riwayat Kiriman", url: "/riwayat/admin/all", icon: "lock" },
    { label: "Payment", url: "/payment-admin/all", icon: "lock" },
    { label: "Profil", url: "/profile", icon: "lock" },
    {
        label: "Pengumuman",
        url: "#",
        icon: "lock",
        menus: [
            { label: "Blast", url: "/blast-notif" },
            { label: "List Pengumuman", url: "/pengumuman" },
        ],
    }, */
    {
        label: "List",
        url: "#",
        icon: "list",
        menus: [
            { label: "Overview", url: "/overview", icon: "bar-chart-2" },
            { label: "Records", url: "/records", icon: "file-text" },
            // { label: "Basic Form", url: "/form", icon: "file-text" },
            // { label: "List Pengumuman", url: "/pengumuman" },
        ],
    },
];
export default {
    created() {
        this.sidemenu = this.getSideMenu();
    },
    methods: {
        getSideMenu: function () {
            var output = '<li class="nav-header">MENU</li>';
            var output = "";
            var menu = sideMenu;
            // console.log("load side menu");
            return output + this.getWalker(menu);
        },
        handleClick(e) {
            var target = e.target.closest(".nav-link");
            if (target) {
                e.preventDefault();
                if (target.getAttribute("href") == "#") {
                    e.preventDefault();
                    return;
                }
                if (this.$route.path != target.getAttribute("href")) {
                    this.$router.push({ path: target.getAttribute("href") });
                    console.log("link", target.getAttribute("href"));
                }
            }
        },
        inMenu(menus, path) {
            if (!menus) return false;
            for (var i in menus) {
                if (menus[i].url == path) {
                    return true;
                }
            }
            return false;
        },
        getWalker(menus) {
            var output = "";
            var currPath = this.$route.path;

            for (var k in menus) {
                var menu = menus[k];
                var menuOpen = "";
                var menuOpenActive = "";
                var attrLink = "";
                var clsLink = "";

                if (currPath == menu.url) clsLink = "active";

                var link = "";
                var clickCallback = null;

                if (typeof menu.url == "string") {
                    link = 'to="' + menu.url + '" href="' + menu.url + '"';
                } else {
                    clickCallback = menu.url;
                }

                if (this.inMenu(menu.menus, currPath)) {
                    menuOpen = "menu-open";
                    clsLink = "active";
                }
                var lbTarget = "";
                if (menu.menus) {
                    lbTarget = "nav" + menu.label;
                    attrLink =
                        'data-bs-toggle="collapse" data-bs-target="#' +
                        lbTarget +
                        '"';
                }

                var ticketBadge = "";

                if (menu.label == "Ticket") {
                    ticketBadge =
                        '<span class="badge badge-primary right" style="padding:0.4em;">' +
                        this.newUpdate +
                        "</span>";
                }

                var tmp =
                    '<li class="' +
                    (menu.menus ? "nav-item has-treeview" : "nav-item") +
                    " " +
                    menuOpen +
                    '">';
                if (menu.url) {
                    tmp +=
                        '<a style="cursor:pointer;" ' +
                        link +
                        ' class="nav-link has-arrow  ' +
                        clsLink +
                        '" ' +
                        attrLink +
                        ">";
                    //tmp += '<i class="' + (menu.icon ? menu.icon : 'd-inline-block') + ' nav-icon"></i>';
                    if (menu.icon)
                        tmp +=
                            '<i data-feather="' +
                            menu.icon +
                            '" class="nav-icon icon-xs me-2"></i>';
                    tmp +=
                        menu.label +
                        (menu.menus
                            ? '<i class="right fi fi-rr-angle-small-right"></i>'
                            : "") +
                        ticketBadge;
                    tmp += "</a>";
                } else {
                    tmp +=
                        '<div class="navbar-heading">' + menu.label + "</div>";
                }

                if (menu.menus) {
                    tmp +=
                        '<div id="' +
                        lbTarget +
                        '" class="collapse " data-bs-parent="#sideNavbar"><ul class="nav flex-column">';
                    tmp += this.getWalker(menu.menus);
                    tmp += "</ul></div>";
                }
                tmp += "</li>";
                output += tmp;
            }
            return output;
        },
    },
    mounted() {
        feather.replace();

        console.log("sidebar loaded");
        if ($(".nav-scroller").length) {
            $(".nav-scroller").slimScroll({
                height: "90%",
            });
        }
        // Menu toggle for admin dashboard

        if ($("#nav-toggle").length) {
            $("#nav-toggle").on("click", function (e) {
                console.log("toogle 1");
                e.preventDefault();
                $("#db-wrapper").toggleClass("toggled");
            });
        }
    },
};
</script>
