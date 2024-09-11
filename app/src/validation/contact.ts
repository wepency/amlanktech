import { object, z } from "zod"

export const ContactSchema = z.object({
  name: z.string().min(1, "الاسم مطلوب"),
  email: z.string().email("الايميل غير صالخ"),
  subject: z.string().min(1, "الرسالة مطلوبة"),
  message: z.string().min(1, "الرسالة مطلوبة"),
})
