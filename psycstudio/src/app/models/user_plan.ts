export class User_plan{
    constructor(
        public id: number,
        public user_id: number,
        public plan_id: number,
        public transaction_id: number,
        public credits: number,
        public remaining_credits: number,
        public status: string
    ){}
}