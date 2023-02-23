export class Therapist_date{
    constructor(
        public id: number,
        public therapist_id: number,
        public start_date: string,
        public end_date: string,
        public schedule_status: string, 
        public status: string,
        public room_id: string
    ){}
}