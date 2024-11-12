const STATUSES_PIPELINE_ORDER = [
    {
        id: 1,
        position: 1,
    },
    {
        id: 6,
        position: 2,
    },
    {
        id: 2,
        position: 3,
    },
    {
        id: 3,
        position: 4,
    },
    {
        id: 4,
        position: 5,
    },
    {
        id: 5,
        position: 6,
    }
];

const STATUSES = {
    CANCEL: 5,
    IN_WORK: 3,
    DONE: 4,
}

const USER_STATUSES = {
    WORKING: 3,
}

export default {
    ORDER_STATUSES: STATUSES,
    ORDER_STATUSES_PIPELINE: STATUSES_PIPELINE_ORDER,
    USER_STATUSES: USER_STATUSES
}