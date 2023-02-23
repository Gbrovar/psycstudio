export class User_date{
    constructor(
        public id: number,
        public user_id: number,
        public date_id: number,
        public therapist_id: number,
        public status: string,
        public transaction_id: string,
        public user_plan: boolean, 
        public user_plan_id: number,
        public user_subscription: boolean,
        public user_subscription_id: number,
        public payment_method: string,
        public room_id: string,
    ){}
}