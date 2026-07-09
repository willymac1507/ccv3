export type Props = {
    student: {
        id: number;
        name: string;
        organisation_id: number;
    };
    appointments: Array<any>;
};

export type PageProps = {
    props: {
        date: Date;
        shift: {
            startTime: string;
            endTime: string;
            breakTime: string;
            id: number;
            user_id: number;
            day: string;
            duration: number;
        };
    };
};
