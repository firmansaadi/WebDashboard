const exampleRoutes = [{
    path: "/examples/table",
    component: () =>
        import ('@/views/examples/Table.vue'),
    name: "examples.table",
    meta: {
        layout: 'admin',
        auth: false,
    },
}, ];

export default exampleRoutes;