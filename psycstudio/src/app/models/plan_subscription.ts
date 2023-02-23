export class Plan_subscription{
    constructor(
        public id: number,
        public name: string,
        public description: string,
        public status: string,
        public price: string, 
        public credits: string,
        public product_id: string,
        public price_id: string
    ){}
}