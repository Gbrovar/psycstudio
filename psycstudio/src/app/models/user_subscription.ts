export class User_subscriptions{
    constructor(
        public id: number,
        public user_id: number,
        public plan_id: number,
        public transaction_id: number,
        public credits: number,
        public remaining_credits: number,
        public status: string,
        public period_start: string,
        public period_end: string,
        public cancel: boolean,
        public cancel_at: string,
        public ended_at: string,
        public interval_billing: string
    ){}
}