import { defineStore } from 'pinia'
import axios from 'axios'

export const useCaptchaStore = defineStore('captcha', {
    state: () => ({
        image: '',
        error: '',
        isLoading: false,
    }),

    actions: {
        async refresh() {
            if (this.isLoading) return

            this.isLoading = true

            try {
                const response = await axios.get('/captcha/generate')
                const newImage = response.data.captcha

                const img = new Image()
                img.src = newImage

                await new Promise((resolve) => {
                    img.onload = resolve
                })

                this.image = newImage
            } catch (error) {
                this.error = 'Failed to load captcha. Please try again.'
            } finally {
                this.isLoading = false
            }
        },
    },
})
