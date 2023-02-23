export class User_transactions{
    constructor(
        public id: number,
        public user_id: number,
        public payment_method: string,
        public payment_id: string
    ){}
}